<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    protected AuditLogService $auditLog;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuditLogService $auditLog)
    {
        $this->middleware('guest')->except('logout');
        $this->auditLog = $auditLog;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Check rate limiting
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
                $request->session()->put('last_activity', time());
            }

            // Clear login attempts
            RateLimiter::clear($this->throttleKey($request));

            // Log successful login
            $this->auditLog->logLogin(true, Auth::user()->email);

            // Role-based redirect
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->isTeacher()) {
                return redirect()->intended('/teacher/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        // Increment login attempts
        RateLimiter::hit($this->throttleKey($request));

        // Log failed login attempt
        $this->auditLog->logLogin(false, $request->input('email'));

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), 5);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ])],
        ])->status(429);
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function fireLockoutEvent(Request $request)
    {
        event(new \Illuminate\Auth\Events\Lockout($request));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Log the logout activity
        $this->auditLog->logLogout();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // Clear any additional session data if needed
        $request->session()->forget('last_activity');
        
        return null;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\HtmlPurifierService;
use App\Services\SecureFileStorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test HTML purification removes dangerous content
     */
    public function test_html_purifier_removes_dangerous_content(): void
    {
        $purifier = app(HtmlPurifierService::class);

        // Test script tag removal
        $html = '<p>Hello</p><script>alert("XSS")</script>';
        $cleaned = $purifier->purify($html);
        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringContainsString('<p>Hello</p>', $cleaned);

        // Test javascript: URL removal
        $html = '<a href="javascript:alert(1)">Click</a>';
        $cleaned = $purifier->purify($html);
        $this->assertStringNotContainsString('javascript:', $cleaned);

        // Test event handler removal
        $html = '<img src="x" onerror="alert(1)">';
        $cleaned = $purifier->purify($html);
        $this->assertStringNotContainsString('onerror', $cleaned);
    }

    /**
     * Test text sanitization
     */
    public function test_text_sanitization(): void
    {
        $purifier = app(HtmlPurifierService::class);

        $text = '<script>alert("XSS")</script>Hello World';
        $cleaned = $purifier->sanitizeText($text);
        
        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringContainsString('Hello World', $cleaned);
    }

    /**
     * Test filename sanitization
     */
    public function test_filename_sanitization(): void
    {
        $purifier = app(HtmlPurifierService::class);

        // Test directory traversal prevention
        $filename = '../../../etc/passwd';
        $cleaned = $purifier->sanitizeFilename($filename);
        $this->assertStringNotContainsString('..', $cleaned);

        // Test special character removal
        $filename = 'file<>:"|?*.txt';
        $cleaned = $purifier->sanitizeFilename($filename);
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9._-]+$/', $cleaned);
    }

    /**
     * Test CSRF protection on forms
     */
    public function test_csrf_protection_on_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Should fail without CSRF token
        $response->assertStatus(419); // CSRF token mismatch
    }

    /**
     * Test secure file upload validation
     */
    public function test_secure_file_upload_rejects_dangerous_files(): void
    {
        Storage::fake('uploads');

        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        // Try to upload a PHP file disguised as image
        $file = UploadedFile::fake()->create('malicious.php.jpg', 100);

        $response = $this->post('/admin/pages', [
            'title' => 'Test Page',
            'slug' => 'test-page',
            'status' => 'draft',
            'banner_image' => $file,
        ]);

        // Should be rejected
        $response->assertSessionHasErrors('banner_image');
    }

    /**
     * Test audit logging for login
     */
    public function test_audit_log_created_on_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $user->id,
            'action' => 'login_success',
        ]);
    }

    /**
     * Test audit log for failed login
     */
    public function test_audit_log_created_on_failed_login(): void
    {
        $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'login_failed',
        ]);
    }

    /**
     * Test input sanitization middleware
     */
    public function test_input_sanitization_removes_null_bytes(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        $response = $this->post('/admin/pages', [
            'title' => "Test\0Title", // Contains null byte
            'slug' => 'test-title',
            'status' => 'draft',
        ]);

        // The null byte should be removed by SanitizeInput middleware
        // The request should process normally
        $this->assertDatabaseMissing('pages', [
            'title' => "Test\0Title",
        ]);
    }

    /**
     * Test security monitoring detects SQL injection
     */
    public function test_security_monitoring_logs_sql_injection_attempt(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Attempt SQL injection
        $this->get('/search?q=\' OR 1=1--');

        // Should log security event
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'security_sql_injection_attempt',
        ]);
    }

    /**
     * Test security monitoring detects XSS attempt
     */
    public function test_security_monitoring_logs_xss_attempt(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Attempt XSS
        $this->post('/search', [
            'q' => '<script>alert("XSS")</script>',
        ]);

        // Should log security event
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'security_xss_attempt',
        ]);
    }
}

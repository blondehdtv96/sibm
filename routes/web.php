<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Public\PageController as PublicPageController;
use App\Http\Controllers\Public\NewsController as PublicNewsController;
use App\Http\Controllers\Public\CompetencyController as PublicCompetencyController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\InfoController;
use App\Http\Controllers\Public\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public search route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Public info routes
Route::get('/about', [InfoController::class, 'about'])->name('info.about');
Route::get('/overview', [InfoController::class, 'overview'])->name('info.overview');
Route::get('/principal-message', [InfoController::class, 'principalMessage'])->name('info.principal-message');
Route::get('/contact', [InfoController::class, 'contact'])->name('info.contact');
Route::post('/contact', [InfoController::class, 'sendContact'])->name('info.contact.send');

// Public page routes
Route::get('/pages/{slug}', [PublicPageController::class, 'show'])->name('public.pages.show');

// Public news routes
Route::get('/news', [PublicNewsController::class, 'index'])->name('public.news.index');
Route::get('/news/{news:slug}', [PublicNewsController::class, 'show'])->name('public.news.show');

// Public competency routes
Route::get('/competencies', [PublicCompetencyController::class, 'index'])->name('public.competencies.index');
Route::get('/competencies/{competency:slug}', [PublicCompetencyController::class, 'show'])->name('public.competencies.show');

// Public gallery routes
Route::get('/gallery', [\App\Http\Controllers\Public\GalleryController::class, 'index'])->name('public.gallery.index');
Route::get('/gallery/{galleryAlbum:slug}', [\App\Http\Controllers\Public\GalleryController::class, 'show'])->name('public.gallery.show');

// Public PPDB routes
Route::get('/ppdb/register', [\App\Http\Controllers\Public\PpdbController::class, 'index'])->name('ppdb.register');
Route::post('/ppdb/register', [\App\Http\Controllers\Public\PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/success/{registrationNumber}', [\App\Http\Controllers\Public\PpdbController::class, 'success'])->name('ppdb.success');
Route::get('/ppdb/check-status', [\App\Http\Controllers\Public\PpdbController::class, 'checkStatus'])->name('ppdb.check-status');
Route::post('/ppdb/check-status', [\App\Http\Controllers\Public\PpdbController::class, 'showStatus'])->name('ppdb.show-status');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes (only if no admin exists)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard routes (will be protected by middleware)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'session.timeout'])->name('dashboard');

Route::get('/admin/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'session.timeout', 'admin'])
    ->name('admin.dashboard');

Route::get('/teacher/dashboard', function () {
    return view('teacher.dashboard');
})->middleware(['auth', 'session.timeout', 'teacher'])->name('teacher.dashboard');

// Demo routes (for development/testing)
Route::get('/demo/interactive-components', function () {
    return view('demo.interactive-components');
})->middleware(['auth'])->name('demo.interactive-components');

// Admin routes
Route::middleware(['auth', 'session.timeout', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard data API
    Route::get('dashboard/data', [\App\Http\Controllers\Admin\DashboardController::class, 'getData'])->name('dashboard.data');
    Route::get('dashboard/export', [\App\Http\Controllers\Admin\DashboardController::class, 'exportStatistics'])->name('dashboard.export');
    
    // Page management routes
    Route::resource('pages', PageController::class);
    Route::patch('pages/{page}/toggle-status', [PageController::class, 'toggleStatus'])->name('pages.toggle-status');
    
    // News category management routes
    Route::resource('news-categories', \App\Http\Controllers\Admin\NewsCategoryController::class);
    
    // News management routes
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    
    // Competency management routes
    Route::resource('competencies', \App\Http\Controllers\Admin\CompetencyController::class);
    Route::post('competencies/update-order', [\App\Http\Controllers\Admin\CompetencyController::class, 'updateOrder'])->name('competencies.update-order');
    
    // Competency Images management routes
    Route::get('competencies/{competency}/images', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'index'])->name('competencies.images.index');
    Route::get('competencies/{competency}/images/create', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'create'])->name('competencies.images.create');
    Route::post('competencies/{competency}/images', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'store'])->name('competencies.images.store');
    Route::get('competencies/{competency}/images/{image}/edit', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'edit'])->name('competencies.images.edit');
    Route::put('competencies/{competency}/images/{image}', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'update'])->name('competencies.images.update');
    Route::delete('competencies/{competency}/images/{image}', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'destroy'])->name('competencies.images.destroy');
    Route::post('competencies/{competency}/images/reorder', [\App\Http\Controllers\Admin\CompetencyImageController::class, 'reorder'])->name('competencies.images.reorder');
    
    // Gallery album management routes
    Route::resource('gallery-albums', \App\Http\Controllers\Admin\GalleryAlbumController::class);
    Route::post('gallery-albums/update-order', [\App\Http\Controllers\Admin\GalleryAlbumController::class, 'updateOrder'])->name('gallery-albums.update-order');
    
    // Gallery item management routes
    Route::resource('gallery-items', \App\Http\Controllers\Admin\GalleryItemController::class)->except(['index', 'show']);
    Route::post('gallery-items/upload-ajax', [\App\Http\Controllers\Admin\GalleryItemController::class, 'uploadAjax'])->name('gallery-items.upload-ajax');
    
    // PPDB settings management routes
    Route::resource('ppdb-settings', \App\Http\Controllers\Admin\PpdbSettingController::class);
    Route::patch('ppdb-settings/{ppdbSetting}/toggle-status', [\App\Http\Controllers\Admin\PpdbSettingController::class, 'toggleStatus'])->name('ppdb-settings.toggle-status');
    
    // PPDB registration management routes
    Route::resource('ppdb-registrations', \App\Http\Controllers\Admin\PpdbRegistrationController::class)->only(['index', 'show', 'destroy']);
    Route::patch('ppdb-registrations/{ppdbRegistration}/verify', [\App\Http\Controllers\Admin\PpdbRegistrationController::class, 'verify'])->name('ppdb-registrations.verify');
    Route::patch('ppdb-registrations/{ppdbRegistration}/reject', [\App\Http\Controllers\Admin\PpdbRegistrationController::class, 'reject'])->name('ppdb-registrations.reject');
    Route::patch('ppdb-registrations/{ppdbRegistration}/update-notes', [\App\Http\Controllers\Admin\PpdbRegistrationController::class, 'updateNotes'])->name('ppdb-registrations.update-notes');
    Route::get('ppdb-registrations/{ppdbRegistration}/download-document/{documentKey}', [\App\Http\Controllers\Admin\PpdbRegistrationController::class, 'downloadDocument'])->name('ppdb-registrations.download-document');
    
    // User management routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/bulk-action', [\App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('users.bulk-action');
    
    // Notification routes
    Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('notifications/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('notifications/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    
    // Chat History routes
    Route::get('chat-history', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'index'])->name('chat-history.index');
    Route::delete('chat-history/{id}', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'destroy'])->name('chat-history.destroy');
    Route::post('chat-history/destroy-all', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'destroyAll'])->name('chat-history.destroy-all');
    Route::post('chat-history/destroy-by-date', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'destroyByDate'])->name('chat-history.destroy-by-date');
    Route::get('chat-history/export', [\App\Http\Controllers\Admin\ChatHistoryController::class, 'export'])->name('chat-history.export');
    
    // Chatbot Responses Management routes
    Route::resource('chatbot-responses', \App\Http\Controllers\Admin\ChatbotResponseController::class);
    Route::post('chatbot-responses/{chatbotResponse}/toggle-status', [\App\Http\Controllers\Admin\ChatbotResponseController::class, 'toggleStatus'])->name('chatbot-responses.toggle-status');
    
    // Settings Management routes
    Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/update-general', [\App\Http\Controllers\Admin\SettingController::class, 'updateGeneral'])->name('settings.update-general');
    Route::get('settings/school-content', [\App\Http\Controllers\Admin\SettingController::class, 'schoolContent'])->name('settings.school-content');
    Route::post('settings/update-overview', [\App\Http\Controllers\Admin\SettingController::class, 'updateOverview'])->name('settings.update-overview');
    Route::post('settings/update-principal-message', [\App\Http\Controllers\Admin\SettingController::class, 'updatePrincipalMessage'])->name('settings.update-principal-message');
    Route::delete('settings/delete-principal-photo', [\App\Http\Controllers\Admin\SettingController::class, 'deletePrincipalPhoto'])->name('settings.delete-principal-photo');
    Route::post('settings/update-statistics', [\App\Http\Controllers\Admin\SettingController::class, 'updateStatistics'])->name('settings.update-statistics');
    Route::post('settings/update-ppdb-brochure', [\App\Http\Controllers\Admin\SettingController::class, 'updatePpdbBrochure'])->name('settings.update-ppdb-brochure');
    Route::delete('settings/delete-ppdb-brochure', [\App\Http\Controllers\Admin\SettingController::class, 'deletePpdbBrochure'])->name('settings.delete-ppdb-brochure');
    Route::get('settings/contact-social', [\App\Http\Controllers\Admin\SettingController::class, 'contactSocial'])->name('settings.contact-social');
    Route::post('settings/update-contact', [\App\Http\Controllers\Admin\SettingController::class, 'updateContact'])->name('settings.update-contact');
    Route::post('settings/update-social-media', [\App\Http\Controllers\Admin\SettingController::class, 'updateSocialMedia'])->name('settings.update-social-media');
    
    // Menu Management routes
    Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
    Route::post('menus/reorder', [\App\Http\Controllers\Admin\MenuController::class, 'reorder'])->name('menus.reorder');
    
    // Home Slider Management routes
    Route::resource('home-sliders', \App\Http\Controllers\Admin\HomeSliderController::class);
    Route::post('settings/update-logo', [\App\Http\Controllers\Admin\SettingController::class, 'updateLogo'])->name('settings.update-logo');
    Route::delete('settings/delete-logo', [\App\Http\Controllers\Admin\SettingController::class, 'deleteLogo'])->name('settings.delete-logo');
    Route::post('settings/clear-cache', [\App\Http\Controllers\Admin\SettingController::class, 'clearCache'])->name('settings.clear-cache');
    
    // Backup & Restore routes
    Route::get('backup', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
    Route::post('backup/create', [\App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
    Route::get('backup/download/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
    Route::delete('backup/delete/{filename}', [\App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('backup.delete');
    Route::post('backup/restore', [\App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backup.restore');
    Route::post('backup/upload', [\App\Http\Controllers\Admin\BackupController::class, 'upload'])->name('backup.upload');
});

// Chatbot routes (public)
Route::post('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'sendMessage'])->name('chatbot.send');
# 🔧 TECHNICAL DOCUMENTATION
## SMK Bina Mandiri - Developer Guide

**Version**: 1.0.0  
**Last Updated**: January 14, 2025  
**Target Audience**: Developers & Technical Team

---

## 📋 TABLE OF CONTENTS

1. [Architecture Overview](#architecture-overview)
2. [Database Design](#database-design)
3. [API Endpoints](#api-endpoints)
4. [Code Standards](#code-standards)
5. [Development Workflow](#development-workflow)
6. [Testing Guide](#testing-guide)
7. [Deployment Guide](#deployment-guide)

---

## 🏗️ ARCHITECTURE OVERVIEW

### MVC Pattern
```
Request → Route → Controller → Model → Database
                      ↓
                    View → Response
```

### Key Components

#### 1. Models (app/Models/)
```php
// Example: HomeSlider.php
class HomeSlider extends Model
{
    protected $fillable = ['title', 'subtitle', 'image', 'button_text', 'button_link', 'order', 'is_active'];
    
    // Scopes
    public function scopeActive($query) {
        return $query->where('is_active', true);
    }
    
    public function scopeOrdered($query) {
        return $query->orderBy('order', 'asc');
    }
    
    // Accessors
    public function getImageUrlAttribute() {
        return $this->image ? Storage::url($this->image) : null;
    }
}
```

#### 2. Controllers (app/Http/Controllers/)
```php
// Admin Controller Pattern
class HomeSliderController extends Controller
{
    public function index() {
        $sliders = HomeSlider::latest()->paginate(10);
        return view('admin.home-sliders.index', compact('sliders'));
    }
    
    public function store(Request $request) {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|max:5120',
            // ... more rules
        ]);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }
        
        HomeSlider::create($validated);
        return redirect()->route('admin.home-sliders.index')->with('success', 'Slider created');
    }
}
```


#### 3. Views (resources/views/)
```blade
{{-- Blade Template Pattern --}}
@extends('layouts.admin-modern')

@section('title', 'Home Sliders')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card">
        <div class="card-header">
            <h3>Home Sliders</h3>
            <a href="{{ route('admin.home-sliders.create') }}" class="btn btn-primary">Add New</a>
        </div>
        
        <div class="card-body">
            @foreach($sliders as $slider)
                <div class="slider-item">
                    <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}">
                    <h4>{{ $slider->title }}</h4>
                    <div class="actions">
                        <a href="{{ route('admin.home-sliders.edit', $slider) }}">Edit</a>
                        <form action="{{ route('admin.home-sliders.destroy', $slider) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
```

#### 4. Routes (routes/web.php)
```php
// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/competencies/{slug}', [CompetencyController::class, 'show'])->name('competencies.show');

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('home-sliders', HomeSliderController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('competency-images', CompetencyImageController::class);
});

// API Routes
Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage']);
```


---

## 🗄️ DATABASE DESIGN

### Entity Relationship Diagram

```
users (1) ──────── (*) ppdb_registrations
settings (key-value store)
menus (1) ──────── (*) menus (self-referencing)
home_sliders
competencies (1) ──────── (*) competency_images
chatbot_responses
chat_histories
news (1) ──────── (*) news_categories
pages
gallery_albums (1) ──────── (*) gallery_items
notifications
```

### Table Schemas

#### 1. home_sliders
```sql
CREATE TABLE home_sliders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT NULL,
    image VARCHAR(255) NOT NULL,
    button_text VARCHAR(100) NULL,
    button_link VARCHAR(255) NULL,
    `order` INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_active (`is_active`),
    INDEX idx_order (`order`)
);
```

#### 2. competency_images
```sql
CREATE TABLE competency_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    competency_id BIGINT UNSIGNED NOT NULL,
    image VARCHAR(255) NOT NULL,
    caption VARCHAR(255) NULL,
    `order` INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (competency_id) REFERENCES competencies(id) ON DELETE CASCADE,
    INDEX idx_competency (competency_id),
    INDEX idx_order (`order`)
);
```


#### 3. menus
```sql
CREATE TABLE menus (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    url VARCHAR(255) NULL,
    parent_id BIGINT UNSIGNED NULL,
    `order` INT DEFAULT 0,
    icon VARCHAR(50) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (parent_id) REFERENCES menus(id) ON DELETE CASCADE,
    INDEX idx_parent (parent_id),
    INDEX idx_active (is_active),
    INDEX idx_order (`order`)
);
```

#### 4. settings
```sql
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) UNIQUE NOT NULL,
    value TEXT NULL,
    type VARCHAR(50) DEFAULT 'text',
    `group` VARCHAR(100) DEFAULT 'general',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_key (`key`),
    INDEX idx_group (`group`)
);
```

#### 5. chatbot_responses
```sql
CREATE TABLE chatbot_responses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    keywords TEXT NOT NULL,
    response TEXT NOT NULL,
    category VARCHAR(100) NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_active (is_active),
    INDEX idx_category (category)
);
```


#### 6. chat_histories
```sql
CREATE TABLE chat_histories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    user_message TEXT NOT NULL,
    bot_response TEXT NOT NULL,
    ip_address VARCHAR(45) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_session (session_id),
    INDEX idx_created (created_at)
);
```

### Migration Commands
```bash
# Run all migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh

# Run with seeders
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status
```

### Seeder Commands
```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=HomeSliderSeeder
php artisan db:seed --class=MenuSeeder
php artisan db:seed --class=ChatbotResponseSeeder
php artisan db:seed --class=SchoolContentSeeder
php artisan db:seed --class=ContactSocialSeeder
```

---

## 🔌 API ENDPOINTS

### Chatbot API

#### POST /chatbot/message
Send message to chatbot and get response.

**Request:**
```json
{
    "message": "Apa itu SMK Bina Mandiri?"
}
```

**Response:**
```json
{
    "success": true,
    "response": "SMK Bina Mandiri adalah sekolah menengah kejuruan...",
    "session_id": "abc123xyz"
}
```


**Implementation:**
```php
// ChatbotController.php
public function sendMessage(Request $request)
{
    $validated = $request->validate([
        'message' => 'required|string|max:500'
    ]);
    
    $userMessage = $validated['message'];
    $sessionId = session()->getId();
    
    // Find matching response
    $response = ChatbotResponse::active()
        ->get()
        ->first(function ($item) use ($userMessage) {
            $keywords = explode(',', $item->keywords);
            foreach ($keywords as $keyword) {
                if (stripos($userMessage, trim($keyword)) !== false) {
                    return true;
                }
            }
            return false;
        });
    
    $botResponse = $response ? $response->response : 'Maaf, saya tidak mengerti pertanyaan Anda.';
    
    // Save to history
    ChatHistory::create([
        'session_id' => $sessionId,
        'user_message' => $userMessage,
        'bot_response' => $botResponse,
        'ip_address' => $request->ip()
    ]);
    
    return response()->json([
        'success' => true,
        'response' => $botResponse,
        'session_id' => $sessionId
    ]);
}
```

### PPDB API (Internal)

#### POST /ppdb/register
Submit PPDB registration.

**Request (multipart/form-data):**
```
name: John Doe
email: john@example.com
phone: 08123456789
address: Jl. Example No. 123
birth_date: 2005-01-15
birth_place: Jakarta
gender: male
school_origin: SMP Negeri 1
major_choice_1: tkj
major_choice_2: rpl
father_name: John Doe Sr.
mother_name: Jane Doe
parent_phone: 08198765432
ktp_file: [file]
kk_file: [file]
ijazah_file: [file]
photo_file: [file]
```

**Response:**
```json
{
    "success": true,
    "message": "Registration successful",
    "registration_number": "PPDB2025001234"
}
```

---

## 📐 CODE STANDARDS

### PHP Coding Standards (PSR-12)

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Models\HomeSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = HomeSlider::latest()->paginate(10);
        
        return view('admin.home-sliders.index', compact('sliders'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'button_text' => 'nullable|max:100',
            'button_link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }
        
        HomeSlider::create($validated);
        
        return redirect()
            ->route('admin.home-sliders.index')
            ->with('success', 'Slider berhasil ditambahkan');
    }
}
```


### Blade Template Standards

```blade
{{-- Use proper indentation --}}
@extends('layouts.admin-modern')

@section('title', 'Page Title')

@section('content')
    <div class="container mx-auto px-4">
        {{-- Use components for reusable elements --}}
        <x-page-loader />
        
        {{-- Proper conditional rendering --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        {{-- Loop with proper checks --}}
        @forelse($items as $item)
            <div class="item">
                <h3>{{ $item->title }}</h3>
                <p>{{ Str::limit($item->description, 100) }}</p>
            </div>
        @empty
            <p>No items found.</p>
        @endforelse
        
        {{-- Pagination --}}
        {{ $items->links() }}
    </div>
@endsection

@push('scripts')
    <script>
        // Page-specific JavaScript
        console.log('Page loaded');
    </script>
@endpush
```

### JavaScript Standards

```javascript
// Use modern ES6+ syntax
const initSlider = () => {
    const slider = new Swiper('.home-hero-slider', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
};

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', initSlider);
```


### CSS/Tailwind Standards

```html
<!-- Use Tailwind utility classes -->
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Title</h3>
            <p class="text-gray-600">Description text here</p>
        </div>
    </div>
</div>

<!-- Responsive design -->
<div class="text-sm md:text-base lg:text-lg">
    Responsive text
</div>

<!-- Custom classes when needed -->
<style>
.custom-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
```

---

## 🔄 DEVELOPMENT WORKFLOW

### Git Workflow

```bash
# 1. Create feature branch
git checkout -b feature/home-slider

# 2. Make changes and commit
git add .
git commit -m "feat: add home slider management"

# 3. Push to remote
git push origin feature/home-slider

# 4. Create pull request
# Review and merge to main

# 5. Update local main
git checkout main
git pull origin main
```

### Commit Message Convention

```
feat: add new feature
fix: bug fix
docs: documentation update
style: code formatting
refactor: code refactoring
test: add tests
chore: maintenance tasks

Examples:
feat: add home slider CRUD
fix: resolve image upload issue
docs: update API documentation
refactor: optimize database queries
```


### Local Development Setup

```bash
# 1. Clone repository
git clone https://github.com/your-repo/sibm.git
cd sibm

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
copy .env.example .env
php artisan key:generate

# 4. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sibm
DB_USERNAME=root
DB_PASSWORD=

# 5. Run migrations and seeders
php artisan migrate:fresh --seed

# 6. Create storage link
php artisan storage:link

# 7. Build assets
npm run dev

# 8. Start development server
php artisan serve
```

### Development Commands

```bash
# Clear all caches
php artisan optimize:clear

# Run specific cache clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generate IDE helper (optional)
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models

# Run queue worker (if using queues)
php artisan queue:work

# Run scheduler (if using scheduled tasks)
php artisan schedule:work
```

---

## 🧪 TESTING GUIDE

### Unit Testing

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HomeSlider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeSliderTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_can_create_a_slider()
    {
        $slider = HomeSlider::create([
            'title' => 'Test Slider',
            'subtitle' => 'Test Subtitle',
            'image' => 'test.jpg',
            'order' => 1,
            'is_active' => true,
        ]);
        
        $this->assertDatabaseHas('home_sliders', [
            'title' => 'Test Slider',
        ]);
    }
    
    /** @test */
    public function it_returns_only_active_sliders()
    {
        HomeSlider::factory()->create(['is_active' => true]);
        HomeSlider::factory()->create(['is_active' => false]);
        
        $activeSliders = HomeSlider::active()->get();
        
        $this->assertCount(1, $activeSliders);
    }
}
```


### Feature Testing

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\HomeSlider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HomeSliderControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function admin_can_view_sliders_list()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->get(route('admin.home-sliders.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('admin.home-sliders.index');
    }
    
    /** @test */
    public function admin_can_create_slider()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post(route('admin.home-sliders.store'), [
                'title' => 'New Slider',
                'subtitle' => 'Subtitle',
                'image' => UploadedFile::fake()->image('slider.jpg'),
                'button_text' => 'Click Here',
                'button_link' => 'https://example.com',
                'order' => 1,
                'is_active' => true,
            ]);
        
        $response->assertRedirect(route('admin.home-sliders.index'));
        $this->assertDatabaseHas('home_sliders', [
            'title' => 'New Slider',
        ]);
        Storage::disk('public')->assertExists('sliders');
    }
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Unit/HomeSliderTest.php

# Run with coverage
php artisan test --coverage

# Run specific test method
php artisan test --filter=it_can_create_a_slider
```

---

## 🚀 DEPLOYMENT GUIDE

### Production Checklist

```bash
# 1. Update .env for production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://smkbinamandiri.sch.id

# 2. Optimize application
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Build production assets
npm run build

# 4. Set proper permissions
chmod -R 755 storage bootstrap/cache
chmod 644 .env

# 5. Run migrations
php artisan migrate --force

# 6. Create storage link
php artisan storage:link
```


### Server Configuration

#### Apache (.htaccess)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name smkbinamandiri.sch.id;
    root /var/www/sibm/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### SSL Configuration (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d smkbinamandiri.sch.id

# Auto-renewal
sudo certbot renew --dry-run
```

### Database Backup Script

```bash
#!/bin/bash
# backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/sibm"
DB_NAME="sibm"
DB_USER="root"
DB_PASS="your_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Backup files
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/sibm/storage

# Remove old backups (keep last 7 days)
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $DATE"
```

### Cron Jobs

```bash
# Edit crontab
crontab -e

# Add Laravel scheduler
* * * * * cd /var/www/sibm && php artisan schedule:run >> /dev/null 2>&1

# Daily backup at 2 AM
0 2 * * * /var/www/sibm/backup.sh

# Clear logs weekly
0 0 * * 0 cd /var/www/sibm && php artisan log:clear
```

---

## 🔍 DEBUGGING TIPS

### Enable Debug Mode
```env
# .env (development only!)
APP_DEBUG=true
APP_ENV=local
LOG_LEVEL=debug
```

### Common Debug Commands

```bash
# View logs
tail -f storage/logs/laravel.log

# Tinker (interactive shell)
php artisan tinker
>>> App\Models\HomeSlider::count()
>>> DB::table('settings')->get()

# Route debugging
php artisan route:list
php artisan route:list --name=admin

# Database queries logging
DB::enableQueryLog();
// ... your code
dd(DB::getQueryLog());
```


### Laravel Telescope (Optional)

```bash
# Install Telescope
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate

# Access Telescope
http://127.0.0.1:8000/telescope
```

### Performance Profiling

```php
// In controller
use Illuminate\Support\Facades\DB;

public function index()
{
    DB::enableQueryLog();
    
    $sliders = HomeSlider::with('images')->get();
    
    // Log queries
    \Log::info(DB::getQueryLog());
    
    return view('home', compact('sliders'));
}
```

---

## 📊 PERFORMANCE OPTIMIZATION

### Database Optimization

```php
// Use eager loading to prevent N+1 queries
$competencies = Competency::with('images')->get();

// Use select to load only needed columns
$sliders = HomeSlider::select('id', 'title', 'image')->get();

// Use chunk for large datasets
HomeSlider::chunk(100, function ($sliders) {
    foreach ($sliders as $slider) {
        // Process slider
    }
});

// Add database indexes
Schema::table('home_sliders', function (Blueprint $table) {
    $table->index('is_active');
    $table->index('order');
});
```

### Caching Strategies

```php
// Cache settings
$settings = Cache::remember('settings', 3600, function () {
    return Setting::pluck('value', 'key')->toArray();
});

// Cache menus
$menus = Cache::remember('menus', 3600, function () {
    return Menu::active()->whereNull('parent_id')->with('children')->get();
});

// Clear cache
Cache::forget('settings');
Cache::flush(); // Clear all
```

### Image Optimization

```bash
# Install image optimization tools
composer require intervention/image

# Optimize on upload
use Intervention\Image\Facades\Image;

$image = Image::make($request->file('image'))
    ->resize(1920, 1080, function ($constraint) {
        $constraint->aspectRatio();
        $constraint->upsize();
    })
    ->encode('jpg', 80);

Storage::put('sliders/optimized.jpg', $image);
```

---

## 🔐 SECURITY BEST PRACTICES

### Input Validation

```php
// Always validate user input
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
]);

// Use prepared statements (Laravel does this automatically)
$users = DB::table('users')->where('email', $email)->get();
```

### XSS Prevention

```blade
{{-- Blade automatically escapes output --}}
{{ $user->name }} {{-- Safe --}}

{{-- Use {!! !!} only for trusted HTML --}}
{!! $trustedHtml !!}

{{-- Sanitize user input --}}
{{ strip_tags($user->bio) }}
```

### CSRF Protection

```blade
{{-- All forms must include CSRF token --}}
<form method="POST" action="/submit">
    @csrf
    <!-- form fields -->
</form>

{{-- For AJAX requests --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
```

### File Upload Security

```php
// Validate file type and size
$request->validate([
    'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
    'document' => 'required|mimes:pdf,doc,docx|max:10240',
]);

// Store outside public directory
$path = $request->file('document')->store('documents', 'private');

// Generate unique filenames
$filename = Str::uuid() . '.' . $request->file('image')->extension();
```

---

## 📚 USEFUL RESOURCES

### Laravel Documentation
- Official Docs: https://laravel.com/docs
- Laracasts: https://laracasts.com
- Laravel News: https://laravel-news.com

### Frontend Resources
- Tailwind CSS: https://tailwindcss.com/docs
- Alpine.js: https://alpinejs.dev
- Swiper.js: https://swiperjs.com

### Tools
- Laravel Debugbar: https://github.com/barryvdh/laravel-debugbar
- Laravel Telescope: https://laravel.com/docs/telescope
- PHPStan: https://phpstan.org

---

**Last Updated**: January 14, 2025  
**Version**: 1.0.0  
**Maintained by**: Development Team

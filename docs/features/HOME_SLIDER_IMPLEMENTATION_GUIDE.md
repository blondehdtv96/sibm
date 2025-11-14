# Home Slider Management System - Implementation Guide

## Overview
Sistem manajemen slider untuk homepage yang memungkinkan admin mengelola gambar hero slider dengan judul, subtitle, dan call-to-action button.

## Database Schema

### Table: home_sliders ✅ CREATED
```sql
- id (bigint, primary key)
- image_path (string) - Path file gambar
- title (string, nullable) - Judul slide
- subtitle (text, nullable) - Subtitle/deskripsi
- button_text (string, nullable) - Text tombol CTA
- button_link (string, nullable) - Link tombol CTA
- order (integer) - Urutan tampilan
- status (enum: active, inactive) - Status slide
- created_at, updated_at (timestamps)
```

## Files Structure

### Models ✅ CREATED
- `app/Models/HomeSlider.php`

### Controllers (TO CREATE)
```php
// app/Http/Controllers/Admin/HomeSliderController.php
- index() - List sliders
- create() - Form tambah slider
- store() - Save slider baru
- edit() - Form edit slider
- update() - Update slider
- destroy() - Delete slider
- reorder() - Reorder slides
```

### Views (TO CREATE)
```
resources/views/admin/home-sliders/
├── index.blade.php   - List & manage sliders
├── create.blade.php  - Upload slider form
└── edit.blade.php    - Edit slider form
```

### Routes (TO ADD)
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('home-sliders', HomeSliderController::class);
    Route::post('home-sliders/reorder', [HomeSliderController::class, 'reorder']);
});
```

## Implementation Steps

### Step 1: Create Controller
```bash
php artisan make:controller Admin/HomeSliderController --resource
```

### Step 2: Implement Controller Methods
Similar to CompetencyImageController with:
- Image upload validation
- Order management
- Status toggle
- CRUD operations

### Step 3: Create Admin Views
- Grid/list view dengan preview gambar
- Upload form dengan fields:
  - Image (required)
  - Title (optional)
  - Subtitle (optional)
  - Button Text (optional)
  - Button Link (optional)
  - Order (required)
  - Status (required)

### Step 4: Update Home Controller
```php
// app/Http/Controllers/HomeController.php
public function index()
{
    $sliders = HomeSlider::active()->ordered()->get();
    // ... other data
    return view('public.home', compact('sliders', ...));
}
```

### Step 5: Redesign Homepage
Update `resources/views/public/home.blade.php` dengan:
- Hero slider section (Swiper.js)
- Modern design dengan Tailwind CSS
- Responsive layout
- Smooth animations

## Homepage Design Concept

### Hero Slider Section
```blade
<!-- Hero Slider -->
<section class="relative h-screen">
    <div class="swiper home-hero-slider h-full">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <!-- Background Image -->
                    <div class="absolute inset-0">
                        <img src="{{ $slider->image_url }}" 
                             alt="{{ $slider->title }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/30"></div>
                    </div>
                    
                    <!-- Content -->
                    <div class="relative z-10 h-full flex items-center">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="max-w-3xl">
                                @if($slider->title)
                                    <h1 class="text-5xl md:text-7xl font-black text-white mb-6 animate-fade-in-up">
                                        {{ $slider->title }}
                                    </h1>
                                @endif
                                
                                @if($slider->subtitle)
                                    <p class="text-xl md:text-2xl text-white/90 mb-8 animate-fade-in-up animation-delay-200">
                                        {{ $slider->subtitle }}
                                    </p>
                                @endif
                                
                                @if($slider->button_text && $slider->button_link)
                                    <a href="{{ $slider->button_link }}" 
                                       class="inline-flex items-center px-8 py-4 bg-blue-600 text-white rounded-xl font-bold text-lg hover:bg-blue-700 transform hover:scale-105 transition-all animate-fade-in-up animation-delay-400">
                                        {{ $slider->button_text }}
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Navigation -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>
```

### Swiper.js Configuration
```javascript
const homeSlider = new Swiper('.home-hero-slider', {
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
```

## Admin Interface Design

### Slider Management Page
```
┌─────────────────────────────────────────────────────┐
│ Home Slider Management              [+ Upload Slider]│
├─────────────────────────────────────────────────────┤
│                                                       │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐          │
│  │  Image   │  │  Image   │  │  Image   │          │
│  │  #1      │  │  #2      │  │  #3      │          │
│  │  Active  │  │  Active  │  │  Inactive│          │
│  │ [Edit]   │  │ [Edit]   │  │ [Edit]   │          │
│  │ [Delete] │  │ [Delete] │  │ [Delete] │          │
│  └──────────┘  └──────────┘  └──────────┘          │
│                                                       │
└─────────────────────────────────────────────────────┘
```

### Upload/Edit Form
```
┌─────────────────────────────────────────────────────┐
│ Upload Slider Image                                  │
├─────────────────────────────────────────────────────┤
│                                                       │
│  Image * (JPG, PNG, max 5MB)                        │
│  [Choose File] [Preview]                            │
│                                                       │
│  Title (Optional)                                    │
│  [_____________________________________________]     │
│                                                       │
│  Subtitle (Optional)                                 │
│  [_____________________________________________]     │
│  [_____________________________________________]     │
│                                                       │
│  Button Text (Optional)                              │
│  [_____________________________________________]     │
│                                                       │
│  Button Link (Optional)                              │
│  [_____________________________________________]     │
│                                                       │
│  Order: [___]  Status: [Active ▼]                   │
│                                                       │
│  [Cancel]  [Save Slider]                            │
│                                                       │
└─────────────────────────────────────────────────────┘
```

## Features

### Admin Features
- ✅ Upload multiple slider images
- ✅ Add title, subtitle, CTA button
- ✅ Reorder slides (drag & drop or manual)
- ✅ Toggle active/inactive status
- ✅ Preview before publish
- ✅ Delete slides
- ✅ Image validation & optimization

### Frontend Features
- ✅ Full-screen hero slider
- ✅ Smooth transitions (fade effect)
- ✅ Autoplay with pause on hover
- ✅ Navigation arrows & pagination
- ✅ Responsive design
- ✅ Touch/swipe support (mobile)
- ✅ Lazy loading images
- ✅ SEO-friendly alt tags

## Validation Rules

### Image Upload
```php
'image' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB
'title' => 'nullable|string|max:255',
'subtitle' => 'nullable|string|max:500',
'button_text' => 'nullable|string|max:50',
'button_link' => 'nullable|url|max:255',
'order' => 'required|integer|min:0',
'status' => 'required|in:active,inactive',
```

## Storage

Slider images stored in:
```
storage/app/public/sliders/
  - slider_1736345678.jpg
  - slider_1736345679.jpg
```

## Best Practices

### Image Specifications
- **Resolution**: 1920x1080px (Full HD) or 2560x1440px (2K)
- **Aspect Ratio**: 16:9
- **Format**: JPG (photos), PNG (graphics with transparency)
- **Size**: < 500KB (compressed)
- **Quantity**: 3-5 slides optimal

### Content Guidelines
- **Title**: Max 50 characters, impactful
- **Subtitle**: Max 150 characters, descriptive
- **Button Text**: Max 20 characters, action-oriented
- **Button Link**: Internal or external URLs

### Performance
- Lazy load images
- Compress images before upload
- Use CDN for Swiper.js
- Optimize autoplay timing
- Preload first slide

## Integration with Existing System

### Add to Sidebar Menu
```blade
<!-- In admin-modern.blade.php -->
<a href="{{ route('admin.home-sliders.index') }}" 
   class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.home-sliders.*') ? 'bg-ios-blue text-white' : 'text-gray-700 hover:bg-gray-100' }}">
    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    Hero Slider
</a>
```

### Update ViewComposer
Add sliders to SettingsComposer or create separate HomeComposer.

## Sample Seeder

```php
// database/seeders/HomeSliderSeeder.php
public function run()
{
    HomeSlider::create([
        'image_path' => 'sliders/sample1.jpg',
        'title' => 'Selamat Datang di SMK Bina Mandiri',
        'subtitle' => 'Membangun Generasi Unggul dengan Pendidikan Berkualitas',
        'button_text' => 'Daftar Sekarang',
        'button_link' => route('ppdb.register'),
        'order' => 1,
        'status' => 'active',
    ]);
    
    // Add more slides...
}
```

## Testing Checklist

- [ ] Upload slider image
- [ ] Edit slider content
- [ ] Reorder slides
- [ ] Toggle status
- [ ] Delete slider
- [ ] View on homepage
- [ ] Test autoplay
- [ ] Test navigation
- [ ] Test on mobile
- [ ] Test with no sliders (fallback)

## Fallback Design

If no sliders exist, show default hero:
```blade
@if($sliders->count() > 0)
    <!-- Slider -->
@else
    <!-- Default Hero -->
    <section class="hero-default">
        <h1>Welcome to {{ $siteName }}</h1>
        <p>Excellence in Education</p>
        <a href="{{ route('ppdb.register') }}">Daftar Sekarang</a>
    </section>
@endif
```

## Future Enhancements

- [ ] Video slider support
- [ ] Parallax effect
- [ ] Ken Burns effect (zoom animation)
- [ ] Multiple CTA buttons per slide
- [ ] Schedule slides (start/end date)
- [ ] A/B testing
- [ ] Analytics tracking
- [ ] Slide templates
- [ ] Bulk upload
- [ ] Image editor integration

## Support

For implementation assistance:
1. Follow this guide step by step
2. Refer to CompetencyImageController for similar patterns
3. Use Swiper.js documentation: https://swiperjs.com/
4. Test thoroughly before production

## Estimated Time

- Controller & Routes: 1-2 hours
- Admin Views: 2-3 hours
- Homepage Redesign: 3-4 hours
- Testing & Polish: 1-2 hours
- **Total: 7-11 hours**

## Priority Tasks

1. ✅ Create database & model (DONE)
2. Create controller with CRUD
3. Create admin views
4. Add routes & sidebar link
5. Redesign homepage with slider
6. Test & optimize
7. Add sample data

---

**Status**: Database & Model Created ✅
**Next Step**: Create HomeSliderController
**Documentation**: Complete

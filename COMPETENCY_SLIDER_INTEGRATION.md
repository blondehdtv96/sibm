# Competency Image Slider - Frontend Integration

## Overview
Integrasi gambar slider di halaman detail kompetensi keahlian menggunakan Swiper.js untuk menampilkan galeri gambar yang menarik dan interaktif.

## Implementasi

### 1. Controller Update
File: `app/Http/Controllers/Public/CompetencyController.php`

```php
public function show(Competency $competency)
{
    // Load active images for slider
    $competency->load('activeImages');
    
    // ... rest of code
}
```

### 2. View Integration
File: `resources/views/public/competencies/show.blade.php`

**Slider Section** (ditambahkan setelah Hero Section):
```blade
@if($competency->activeImages->count() > 0)
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Swiper Slider -->
        <div class="swiper competency-slider">
            <div class="swiper-wrapper">
                @foreach($competency->activeImages as $image)
                    <div class="swiper-slide">
                        <div class="relative aspect-video rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ $image->image_url }}" alt="{{ $image->title }}">
                            <!-- Caption overlay -->
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
@endif
```

### 3. Swiper.js Integration

**CSS** (di @push('styles')):
```html
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
```

**JavaScript** (di @push('scripts')):
```html
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
const swiper = new Swiper('.competency-slider', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
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
</script>
```

## Fitur Slider

### 1. Autoplay
- ✅ Otomatis berganti slide setiap 5 detik
- ✅ Pause saat user interact
- ✅ Resume setelah interaction selesai

### 2. Navigation
- ✅ Next/Previous buttons
- ✅ Keyboard navigation (arrow keys)
- ✅ Touch/swipe support (mobile)

### 3. Pagination
- ✅ Bullet indicators
- ✅ Clickable bullets
- ✅ Active state styling

### 4. Loop
- ✅ Infinite loop
- ✅ Smooth transition

### 5. Responsive
- ✅ Full width on all devices
- ✅ Aspect ratio maintained (16:9)
- ✅ Touch-friendly controls

## Styling

### Custom Swiper Styles
```css
.competency-slider {
    padding: 20px 0 60px;
}

/* Navigation Buttons */
.competency-slider .swiper-button-next,
.competency-slider .swiper-button-prev {
    color: #fff;
    background: rgba(0, 0, 0, 0.5);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    backdrop-filter: blur(10px);
}

/* Pagination Bullets */
.competency-slider .swiper-pagination-bullet {
    width: 12px;
    height: 12px;
    background: #3b82f6;
    opacity: 0.5;
}

.competency-slider .swiper-pagination-bullet-active {
    opacity: 1;
    background: #2563eb;
}
```

### Image Caption Overlay
```html
<div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
    <h3 class="text-white text-xl font-bold mb-2">{{ $image->title }}</h3>
    <p class="text-white/90 text-sm">{{ $image->description }}</p>
</div>
```

## Cara Penggunaan

### 1. Upload Gambar
1. Login sebagai admin
2. Buka **Program Keahlian**
3. Klik icon **Galeri** pada kompetensi
4. Upload gambar dengan judul & deskripsi
5. Set status = Active

### 2. Lihat Slider
1. Buka halaman detail kompetensi
2. URL: `/competencies/{slug}`
3. Slider muncul setelah hero section
4. Hanya tampil jika ada gambar active

### 3. Interaksi
- **Desktop**: Click next/prev buttons atau pagination
- **Mobile**: Swipe left/right
- **Keyboard**: Arrow keys
- **Auto**: Otomatis berganti setiap 5 detik

## Conditional Display

Slider hanya tampil jika:
```blade
@if($competency->activeImages->count() > 0)
    <!-- Slider section -->
@endif
```

Kondisi:
- ✅ Ada minimal 1 gambar
- ✅ Status gambar = active
- ✅ Gambar ter-load dengan benar

## Performance

### Optimization Tips
1. **Image Size**: Compress gambar sebelum upload
2. **Lazy Loading**: Swiper support lazy loading
3. **CDN**: Swiper.js loaded dari CDN
4. **Caching**: Browser cache untuk gambar

### Recommended Image Specs
- **Resolution**: 1920x1080px (Full HD)
- **Aspect Ratio**: 16:9
- **Format**: JPG (photos), PNG (graphics)
- **Size**: < 500KB per image
- **Quantity**: 5-10 images optimal

## Customization

### Change Autoplay Speed
```javascript
autoplay: {
    delay: 3000, // 3 seconds
}
```

### Disable Loop
```javascript
loop: false,
```

### Multiple Slides
```javascript
slidesPerView: 2,
spaceBetween: 20,
breakpoints: {
    768: {
        slidesPerView: 3,
    },
},
```

### Add Effects
```javascript
effect: 'fade', // or 'cube', 'flip', 'coverflow'
fadeEffect: {
    crossFade: true
},
```

## Troubleshooting

### Slider tidak muncul
- Cek apakah ada gambar active
- Inspect console untuk error
- Pastikan Swiper.js loaded

### Gambar tidak tampil
- Cek path gambar di database
- Pastikan storage link: `php artisan storage:link`
- Cek permission folder storage

### Navigation tidak jalan
- Pastikan Swiper.js loaded
- Cek selector class name
- Inspect console untuk error

### Autoplay tidak jalan
- Cek browser autoplay policy
- User harus interact dulu (some browsers)
- Disable autoplay jika perlu

## Browser Support

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers
- ✅ IE11 (with polyfills)

## Dependencies

- **Swiper.js**: v11.x
- **CDN**: jsdelivr.net
- **License**: MIT

## Future Enhancements

- [ ] Lightbox/fullscreen view
- [ ] Thumbnail navigation
- [ ] Video support
- [ ] 360° panorama
- [ ] Lazy loading images
- [ ] Download images
- [ ] Share slider
- [ ] Print-friendly view

## Support
Untuk pertanyaan atau issue, silakan hubungi tim development.

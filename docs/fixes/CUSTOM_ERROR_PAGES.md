# Custom Error Pages

## Overview
Halaman error custom yang modern dan user-friendly untuk meningkatkan pengalaman pengguna saat terjadi error.

## Halaman Error yang Tersedia

### 1. **404 - Halaman Tidak Ditemukan**
**File**: `resources/views/errors/404.blade.php`

**Kapan Muncul**:
- URL tidak ditemukan (e.g., `/competencies/adsadasdasd`)
- Route tidak ada
- Resource tidak ditemukan

**Fitur**:
- ✅ Animasi 404 yang menarik
- ✅ Pesan error yang jelas
- ✅ Tombol kembali ke beranda
- ✅ Tombol halaman sebelumnya
- ✅ Quick links ke halaman populer
- ✅ Gradient background yang modern
- ✅ Responsive design

**Quick Links**:
- Tentang
- Program Keahlian
- Berita
- Kontak

### 2. **500 - Server Error**
**File**: `resources/views/errors/500.blade.php`

**Kapan Muncul**:
- Internal server error
- Database error
- PHP fatal error
- Uncaught exceptions

**Fitur**:
- ✅ Animasi 500 dengan warna merah/orange
- ✅ Pesan error yang informatif
- ✅ Tombol kembali ke beranda
- ✅ Tombol coba lagi (reload)
- ✅ Link kontak untuk bantuan
- ✅ Gradient background merah/orange

### 3. **403 - Akses Ditolak**
**File**: `resources/views/errors/403.blade.php`

**Kapan Muncul**:
- Akses tanpa permission
- Unauthorized access
- Protected routes
- Admin-only pages

**Fitur**:
- ✅ Animasi 403 dengan warna kuning/merah
- ✅ Pesan akses ditolak yang jelas
- ✅ Tombol kembali ke beranda
- ✅ Tombol login (untuk guest)
- ✅ Link kontak administrator
- ✅ Gradient background kuning/merah

## Design System

### Color Schemes

#### 404 Page
```css
Background: Blue → Purple → Pink gradient
Primary: Blue-600 to Purple-600
Accent: Blue-100, Purple-100
```

#### 500 Page
```css
Background: Red → Orange → Yellow gradient
Primary: Red-600 to Orange-600
Accent: Red-100, Orange-100
```

#### 403 Page
```css
Background: Yellow → Orange → Red gradient
Primary: Yellow-600 to Red-600
Accent: Yellow-100, Red-100
```

### Typography
- **Error Code**: 9xl, font-black, gradient text
- **Title**: 3xl-4xl, font-bold
- **Description**: lg, text-gray-600
- **Buttons**: font-semibold

### Animations
```css
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

@keyframes pulse {
    0%, 100% { opacity: 0.2; }
    50% { opacity: 0.4; }
}
```

## Components

### Action Buttons
1. **Primary Button** (Gradient)
   - Kembali ke Beranda
   - Hover: shadow-xl, translate-y

2. **Secondary Button** (White with border)
   - Halaman Sebelumnya / Coba Lagi / Login
   - Hover: border color change

### Quick Links (404 Only)
- Grid 2x2 (mobile) / 4 columns (desktop)
- Icon dengan background color
- Hover effects
- Links ke halaman populer

### Illustrations
- SVG icons dari Heroicons
- Size: 64x64 (w-64 h-64)
- Color: text-gray-300
- Centered

## Usage

### Automatic Error Handling
Laravel otomatis akan menampilkan halaman error yang sesuai:

```php
// 404 - Not Found
abort(404);

// 403 - Forbidden
abort(403);

// 500 - Server Error
throw new Exception('Something went wrong');
```

### Custom Error Messages
```php
abort(404, 'Custom message here');
```

### In Controllers
```php
public function show($slug)
{
    $item = Item::where('slug', $slug)->first();
    
    if (!$item) {
        abort(404); // Will show custom 404 page
    }
    
    return view('item.show', compact('item'));
}
```

## Customization

### Changing Colors
Edit gradient classes in each error page:
```html
<!-- 404 -->
bg-gradient-to-br from-blue-50 via-purple-50 to-pink-50

<!-- 500 -->
bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50

<!-- 403 -->
bg-gradient-to-br from-yellow-50 via-orange-50 to-red-50
```

### Adding More Quick Links (404)
```html
<a href="{{ route('your.route') }}" 
   class="flex flex-col items-center gap-2 p-4 rounded-xl hover:bg-blue-50 transition-colors group">
    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
        <!-- Your icon here -->
    </div>
    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-600">Your Link</span>
</a>
```

### Changing Messages
Edit the text in each blade file:
```html
<h2 class="text-3xl md:text-4xl font-bold text-gray-900">
    Your Custom Title
</h2>
<p class="text-lg text-gray-600 max-w-md mx-auto">
    Your custom description
</p>
```

## Testing

### Test 404 Error
```
http://localhost:8000/non-existent-page
http://localhost:8000/competencies/invalid-slug
```

### Test 500 Error
Add to a controller temporarily:
```php
public function test()
{
    throw new Exception('Test 500 error');
}
```

### Test 403 Error
Try accessing admin page without permission:
```
http://localhost:8000/admin/dashboard (without login)
```

## Best Practices

### 1. **User-Friendly Messages**
- Jelas dan mudah dipahami
- Tidak teknis
- Memberikan solusi

### 2. **Clear Actions**
- Tombol yang jelas
- Multiple options
- Easy navigation

### 3. **Consistent Design**
- Mengikuti tema website
- Consistent spacing
- Responsive layout

### 4. **Performance**
- Lightweight
- Fast loading
- Minimal dependencies

### 5. **Accessibility**
- Semantic HTML
- Clear contrast
- Keyboard navigation

## Browser Support
- ✅ Chrome/Edge (Latest)
- ✅ Firefox (Latest)
- ✅ Safari (Latest)
- ✅ Mobile browsers

## Future Enhancements
- [ ] Search functionality on 404 page
- [ ] Recent pages visited
- [ ] Error reporting form
- [ ] Multilingual support
- [ ] Dark mode support
- [ ] Analytics tracking
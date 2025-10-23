# 🎬 Loading Animations Documentation

Sistem animasi loading yang modern dan smooth untuk semua proses loading di website.

## ✨ Komponen Loading yang Tersedia

### 1. **Page Loader** 
Animasi loading saat halaman di-refresh atau berpindah halaman.

**Fitur:**
- ✅ Muncul otomatis saat page load
- ✅ Fade out smooth setelah halaman loaded
- ✅ Auto-detect navigation links
- ✅ Auto-detect form submit
- ✅ Spinner dengan icon sekolah
- ✅ Animated dots

**File:** `resources/views/components/page-loader.blade.php`

### 2. **Button Loading**
Loading state untuk tombol saat proses submit.

**Fitur:**
- ✅ Disable button saat loading
- ✅ Spinner animation
- ✅ Custom loading text
- ✅ Auto-restore original text
- ✅ Prevent double submit

**File:** `resources/views/components/button-loading.blade.php`

### 3. **AJAX Loader**
Loading overlay untuk AJAX requests.

**Fitur:**
- ✅ Full screen overlay
- ✅ Custom loading text
- ✅ Auto-detect fetch requests
- ✅ Smooth fade in/out
- ✅ Non-blocking UI

**File:** `resources/views/components/ajax-loader.blade.php`

### 4. **Skeleton Loader**
Placeholder loading untuk content.

**Fitur:**
- ✅ Multiple types (card, table, list, text, image)
- ✅ Pulse animation
- ✅ Customizable count
- ✅ Better UX perception

**File:** `resources/views/components/skeleton-loader.blade.php`

## 📦 Instalasi

Semua komponen sudah otomatis di-include di layout:
- ✅ `layouts/public-tailwind.blade.php`
- ✅ `layouts/admin-modern.blade.php`

Tidak perlu setup tambahan!

## 🎯 Cara Menggunakan

### 1. Page Loader

**Otomatis Aktif:**
- Saat refresh halaman
- Saat klik link navigasi
- Saat submit form

**Disable untuk Link Tertentu:**
```html
<!-- Link ini tidak akan trigger page loader -->
<a href="#section">Hash Link</a>
<a href="https://external.com" target="_blank">External Link</a>
```

**Disable untuk Form Tertentu:**
```html
<!-- Form ini tidak akan trigger page loader -->
<form data-no-loader>
    <!-- form content -->
</form>
```

### 2. Button Loading

**Basic Usage:**
```html
<button type="submit" class="btn-loading" data-loading-text="Menyimpan...">
    Simpan
</button>
```

**Custom Loading Text:**
```html
<button type="submit" class="btn-loading" data-loading-text="Mengirim Data...">
    Kirim
</button>
```

**Programmatic Control:**
```javascript
// Show loading
const button = document.getElementById('myButton');
showButtonLoading(button, 'Memproses...');

// Hide loading
hideButtonLoading(button);
```

### 3. AJAX Loader

**Otomatis Aktif:**
- Semua fetch requests (kecuali /chatbot)

**Manual Control:**
```javascript
// Show loader
showAjaxLoader('Mengupload file...');

// Hide loader
hideAjaxLoader();
```

**Example dengan Fetch:**
```javascript
showAjaxLoader('Menyimpan data...');

fetch('/api/save', {
    method: 'POST',
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => {
    hideAjaxLoader();
    console.log('Success:', data);
})
.catch(error => {
    hideAjaxLoader();
    console.error('Error:', error);
});
```

### 4. Skeleton Loader

**Card Skeleton:**
```blade
@include('components.skeleton-loader', ['type' => 'card', 'count' => 3])
```

**Table Skeleton:**
```blade
<table>
    <tbody>
        @include('components.skeleton-loader', ['type' => 'table', 'count' => 5])
    </tbody>
</table>
```

**List Skeleton:**
```blade
@include('components.skeleton-loader', ['type' => 'list', 'count' => 4])
```

**Text Skeleton:**
```blade
@include('components.skeleton-loader', ['type' => 'text', 'count' => 1])
```

**Image Skeleton:**
```blade
@include('components.skeleton-loader', ['type' => 'image', 'count' => 1])
```

## 🎨 Kustomisasi

### Mengubah Warna Page Loader

Edit `resources/views/components/page-loader.blade.php`:

```html
<!-- Ganti warna spinner -->
<div class="border-t-blue-600 border-r-blue-600">
<!-- Menjadi -->
<div class="border-t-green-600 border-r-green-600">

<!-- Ganti warna icon -->
<svg class="text-blue-600">
<!-- Menjadi -->
<svg class="text-green-600">
```

### Mengubah Durasi Animasi

```css
/* Di component masing-masing */
.animate-spin {
    animation: spin 1s linear infinite; /* Ubah 1s ke durasi lain */
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; /* Ubah 2s */
}
```

### Custom Loader Design

Buat component baru di `resources/views/components/`:

```blade
<!-- custom-loader.blade.php -->
<div id="custom-loader" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center">
    <!-- Your custom design here -->
</div>
```

## 📊 Performance Tips

### 1. Lazy Load Images
```html
<img src="placeholder.jpg" data-src="actual-image.jpg" loading="lazy">
```

### 2. Debounce AJAX Requests
```javascript
let timeout;
function debouncedSearch(query) {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        showAjaxLoader('Mencari...');
        // Perform search
    }, 300);
}
```

### 3. Optimize Skeleton Count
```blade
<!-- Jangan terlalu banyak -->
@include('components.skeleton-loader', ['type' => 'card', 'count' => 3])
<!-- Bukan -->
@include('components.skeleton-loader', ['type' => 'card', 'count' => 20])
```

## 🎭 Animation Types

### Spin Animation
```css
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
```

### Pulse Animation
```css
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
```

### Bounce Animation
```css
@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}
```

### Fade Animation
```css
@keyframes fade {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
```

## 🧪 Testing

### Test Page Loader
1. Buka website
2. Klik link navigasi
3. Loader harus muncul
4. Halaman baru loaded
5. Loader fade out

### Test Button Loading
1. Buka form (contoh: PPDB)
2. Isi form
3. Klik submit
4. Button harus disabled dengan spinner
5. Setelah proses selesai, button kembali normal

### Test AJAX Loader
1. Trigger AJAX request
2. Overlay loader harus muncul
3. Setelah response, loader hilang

### Test Skeleton Loader
1. Tambahkan skeleton di halaman
2. Skeleton harus animate pulse
3. Replace dengan content asli setelah loaded

## 🐛 Troubleshooting

### Page Loader Tidak Muncul
**Solusi:**
1. Check console untuk error
2. Pastikan component di-include di layout
3. Clear cache: `php artisan view:clear`

### Button Loading Tidak Bekerja
**Solusi:**
1. Pastikan button punya class `btn-loading`
2. Check attribute `data-loading-text`
3. Pastikan component di-include

### AJAX Loader Selalu Muncul
**Solusi:**
1. Pastikan `hideAjaxLoader()` dipanggil
2. Check error di fetch request
3. Add try-catch block

### Skeleton Tidak Animate
**Solusi:**
1. Check CSS animate-pulse
2. Pastikan Tailwind CSS loaded
3. Refresh browser cache

## 📱 Mobile Optimization

### Touch-Friendly
- Loader tidak block touch events
- Smooth animations di mobile
- Optimized for low-end devices

### Performance
- Minimal CPU usage
- GPU-accelerated animations
- No layout shift

## 🎓 Best Practices

### DO ✅
- Use page loader untuk navigasi
- Use button loading untuk form submit
- Use AJAX loader untuk background requests
- Use skeleton untuk content loading
- Keep animations smooth (< 1s)
- Test di berbagai device

### DON'T ❌
- Jangan terlalu banyak loader sekaligus
- Jangan animasi terlalu lama (> 3s)
- Jangan block user interaction
- Jangan lupa hide loader
- Jangan overuse skeleton

## 🚀 Advanced Usage

### Chaining Loaders
```javascript
// Show page loader
showAjaxLoader('Memuat data...');

fetch('/api/data')
    .then(response => {
        // Change loader text
        showAjaxLoader('Memproses data...');
        return response.json();
    })
    .then(data => {
        // Hide loader
        hideAjaxLoader();
    });
```

### Conditional Loading
```javascript
if (largeFile) {
    showAjaxLoader('Mengupload file besar...');
} else {
    showAjaxLoader('Mengupload...');
}
```

### Progress Indicator (Future)
```javascript
// Coming soon
showProgressLoader(0); // 0%
updateProgress(50); // 50%
updateProgress(100); // 100%
hideProgressLoader();
```

## 📚 Resources

### Tailwind CSS Animations
- [Tailwind Animation Docs](https://tailwindcss.com/docs/animation)

### CSS Animations
- [MDN Animation Guide](https://developer.mozilla.org/en-US/docs/Web/CSS/animation)

### Performance
- [Web Vitals](https://web.dev/vitals/)

## 🎉 Summary

Sistem loading animations telah diimplementasikan dengan lengkap:

✅ Page Loader - Auto-detect navigation
✅ Button Loading - Prevent double submit
✅ AJAX Loader - Background requests
✅ Skeleton Loader - Content placeholder

Semua loader sudah terintegrasi dan siap digunakan!

---

**Loading Animations - Making Your App Feel Faster! ⚡**

*Last Updated: 15 Oktober 2025*

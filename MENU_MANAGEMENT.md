# Menu Management System

## Overview
Sistem manajemen menu dan submenu yang dinamis untuk mengelola navigasi website tanpa perlu coding.

## Fitur

### 1. CRUD Menu
- ✅ Tambah menu baru
- ✅ Edit menu existing
- ✅ Hapus menu (cascade delete submenu)
- ✅ List semua menu dengan hierarki

### 2. Hierarki Menu
- ✅ Support parent-child relationship
- ✅ Unlimited submenu levels
- ✅ Visual indentation untuk submenu

### 3. Konfigurasi Menu
- **Title**: Judul menu yang ditampilkan
- **URL Type**: 
  - Route Name (e.g., `info.about`)
  - Custom URL (e.g., `/about` atau `https://example.com`)
- **Parent Menu**: Pilih parent untuk membuat submenu
- **Order**: Urutan tampilan menu
- **Icon**: SVG icon (opsional)
- **Target**: `_self` (same window) atau `_blank` (new tab)
- **Status**: Active/Inactive

## Database Schema

### Table: menus
```sql
- id (bigint, primary key)
- title (string) - Judul menu
- url (string, nullable) - Custom URL
- route_name (string, nullable) - Laravel route name
- parent_id (bigint, nullable, foreign key) - Parent menu ID
- order (integer) - Urutan tampilan
- icon (string, nullable) - SVG icon code
- target (enum: _self, _blank) - Link target
- status (enum: active, inactive) - Status menu
- created_at (timestamp)
- updated_at (timestamp)
```

## Files Created

### Controllers
- `app/Http/Controllers/Admin/MenuController.php`

### Models
- `app/Models/Menu.php`

### Migrations
- `database/migrations/2025_01_08_100000_create_menus_table.php`

### Views
- `resources/views/admin/menus/index.blade.php` - List menu
- `resources/views/admin/menus/create.blade.php` - Form tambah menu
- `resources/views/admin/menus/edit.blade.php` - Form edit menu

### Routes
```php
Route::resource('menus', MenuController::class);
Route::post('menus/reorder', [MenuController::class, 'reorder']);
```

## Cara Penggunaan

### 1. Akses Menu Management
- Login sebagai admin
- Buka sidebar → **Menu Navigasi**
- URL: `/admin/menus`

### 2. Tambah Menu Utama
1. Klik tombol **Tambah Menu**
2. Isi form:
   - Judul Menu: "Tentang Kami"
   - Parent Menu: Kosongkan (untuk menu utama)
   - Tipe Link: Pilih "Route Name"
   - Route Name: `info.about`
   - Order: 1
   - Target: Same Window
   - Status: Active
3. Klik **Simpan Menu**

### 3. Tambah Submenu
1. Klik tombol **Tambah Menu**
2. Isi form:
   - Judul Menu: "Selayang Pandang"
   - Parent Menu: Pilih "Tentang Kami"
   - Tipe Link: Pilih "Route Name"
   - Route Name: `info.overview`
   - Order: 1
   - Target: Same Window
   - Status: Active
3. Klik **Simpan Menu**

### 4. Edit Menu
1. Klik tombol **Edit** pada menu yang ingin diubah
2. Update informasi yang diperlukan
3. Klik **Update Menu**

### 5. Hapus Menu
1. Klik tombol **Delete** pada menu yang ingin dihapus
2. Konfirmasi penghapusan
3. Menu dan semua submenu akan terhapus

## Integrasi dengan Frontend

### Mengambil Menu di View
```php
// Di controller atau view composer
$menus = Menu::with('children')
    ->active()
    ->parents()
    ->orderBy('order')
    ->get();
```

### Menampilkan Menu di Navbar
```blade
<nav>
    @foreach($menus as $menu)
        @if($menu->children->count() > 0)
            <!-- Menu dengan submenu -->
            <div class="dropdown">
                <a href="{{ $menu->full_url }}" target="{{ $menu->target }}">
                    @if($menu->icon)
                        {!! $menu->icon !!}
                    @endif
                    {{ $menu->title }}
                </a>
                <div class="dropdown-menu">
                    @foreach($menu->children as $child)
                        <a href="{{ $child->full_url }}" target="{{ $child->target }}">
                            @if($child->icon)
                                {!! $child->icon !!}
                            @endif
                            {{ $child->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Menu tanpa submenu -->
            <a href="{{ $menu->full_url }}" target="{{ $menu->target }}">
                @if($menu->icon)
                    {!! $menu->icon !!}
                @endif
                {{ $menu->title }}
            </a>
        @endif
    @endforeach
</nav>
```

## Model Methods

### Menu Model
```php
// Relationships
$menu->parent;      // Get parent menu
$menu->children;    // Get child menus

// Scopes
Menu::active();     // Only active menus
Menu::parents();    // Only parent menus (no parent_id)

// Attributes
$menu->full_url;    // Get full URL (from route_name or url)
```

## Tips & Best Practices

1. **Gunakan Route Name**: Lebih maintainable daripada hardcode URL
2. **Order Numbering**: Gunakan kelipatan 10 (10, 20, 30) untuk memudahkan insert di tengah
3. **Icon Consistency**: Gunakan icon set yang sama (e.g., Heroicons)
4. **Status Management**: Set inactive untuk hide menu sementara tanpa delete
5. **Cascade Delete**: Hati-hati saat delete parent menu, semua submenu akan terhapus

## Future Enhancements

- [ ] Drag & drop reordering
- [ ] Menu visibility rules (role-based)
- [ ] Menu analytics (click tracking)
- [ ] Multi-language support
- [ ] Menu templates/presets
- [ ] Bulk operations

## Troubleshooting

### Menu tidak muncul di frontend
- Pastikan status menu = "active"
- Cek route name sudah benar
- Pastikan menu sudah di-load di controller/view composer

### Error saat delete menu
- Cek foreign key constraint
- Pastikan tidak ada circular reference

### Submenu tidak tampil
- Pastikan parent_id sudah benar
- Cek relationship di model
- Pastikan eager loading children

## Support
Untuk pertanyaan atau issue, silakan hubungi tim development.

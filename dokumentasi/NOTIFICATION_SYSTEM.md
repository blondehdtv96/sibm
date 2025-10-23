# Sistem Notifikasi Admin

Sistem notifikasi telah berhasil diimplementasikan untuk admin panel. Sistem ini akan memberikan notifikasi real-time kepada admin ketika ada aktivitas penting.

## Fitur yang Diimplementasikan

### 1. **Notifikasi Pendaftaran PPDB Baru**
- Admin akan menerima notifikasi otomatis ketika ada pendaftaran PPDB baru
- Notifikasi mencakup nama siswa dan nomor registrasi
- Link langsung ke detail pendaftaran

### 2. **Dropdown Notifikasi di Header**
- Badge merah menunjukkan jumlah notifikasi yang belum dibaca
- Dropdown menampilkan 5 notifikasi terbaru
- Tombol "Tandai Semua Dibaca" untuk menandai semua notifikasi sekaligus
- Link "Lihat Semua" untuk melihat semua notifikasi

### 3. **Halaman Notifikasi Lengkap**
- Akses melalui menu sidebar "Notifikasi"
- Menampilkan semua notifikasi dengan pagination
- Filter notifikasi yang sudah/belum dibaca
- Tombol untuk menandai sebagai dibaca atau menghapus notifikasi
- Badge counter di menu sidebar menunjukkan jumlah notifikasi belum dibaca

### 4. **Menu Sidebar**
- Menu "Notifikasi" ditambahkan di bagian "Sistem"
- Badge counter merah menunjukkan jumlah notifikasi belum dibaca
- Highlight aktif ketika berada di halaman notifikasi

## File yang Dibuat/Dimodifikasi

### File Baru:
1. `app/Notifications/NewPpdbRegistration.php` - Notification class untuk pendaftaran PPDB baru
2. `app/Http/Controllers/Admin/NotificationController.php` - Controller untuk mengelola notifikasi
3. `resources/views/admin/notifications/index.blade.php` - Halaman daftar notifikasi

### File yang Dimodifikasi:
1. `app/Http/Controllers/Public/PpdbController.php` - Menambahkan pengiriman notifikasi saat pendaftaran baru
2. `resources/views/layouts/admin-modern.blade.php` - Menambahkan dropdown notifikasi dan menu sidebar
3. `routes/web.php` - Menambahkan route untuk notifikasi

## Routes yang Ditambahkan

```php
// Notification routes
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
Route::get('notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
```

## Cara Kerja

### 1. Pengiriman Notifikasi
Ketika ada pendaftaran PPDB baru, sistem akan:
```php
$admins = User::where('role', 'admin')->get();
Notification::send($admins, new NewPpdbRegistration($registration));
```

### 2. Menampilkan Notifikasi
Di layout admin, notifikasi ditampilkan menggunakan:
```php
auth()->user()->unreadNotifications->count() // Jumlah notifikasi belum dibaca
auth()->user()->unreadNotifications->take(5) // 5 notifikasi terbaru
```

### 3. Menandai Sebagai Dibaca
```php
$notification->markAsRead();
```

### 4. Menandai Semua Sebagai Dibaca
```php
auth()->user()->unreadNotifications->markAsRead();
```

## Menambahkan Notifikasi Baru

Untuk menambahkan jenis notifikasi baru:

### 1. Buat Notification Class
```bash
php artisan make:notification NamaNotifikasi
```

### 2. Implementasi Notification
```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NamaNotifikasi extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Judul Notifikasi',
            'message' => 'Pesan notifikasi',
            'icon' => 'icon-name', // optional
            'url' => route('route.name'), // optional
            // data lainnya...
        ];
    }
}
```

### 3. Kirim Notifikasi
```php
use App\Notifications\NamaNotifikasi;
use Illuminate\Support\Facades\Notification;

// Kirim ke satu user
$user->notify(new NamaNotifikasi($data));

// Kirim ke multiple users
$users = User::where('role', 'admin')->get();
Notification::send($users, new NamaNotifikasi($data));
```

## Icon yang Tersedia

Sistem menggunakan Heroicons SVG. Beberapa icon yang umum digunakan:
- `user-plus` - Untuk pendaftaran user baru
- `bell` - Untuk notifikasi umum
- `check-circle` - Untuk konfirmasi/approval
- `exclamation` - Untuk peringatan
- `information-circle` - Untuk informasi

## Styling

Notifikasi menggunakan Tailwind CSS dengan desain modern yang konsisten dengan admin panel:
- Warna biru untuk notifikasi belum dibaca
- Warna abu-abu untuk notifikasi sudah dibaca
- Badge merah untuk counter notifikasi
- Hover effects untuk interaktivitas

## Testing

Untuk testing notifikasi:

1. Login sebagai admin
2. Buka halaman pendaftaran PPDB di frontend
3. Isi dan submit form pendaftaran
4. Kembali ke admin panel
5. Lihat badge notifikasi di header dan sidebar
6. Klik icon notifikasi untuk melihat dropdown
7. Klik "Lihat Semua" untuk melihat halaman notifikasi lengkap

## Future Enhancements

Beberapa enhancement yang bisa ditambahkan:
1. Real-time notifications menggunakan WebSocket/Pusher
2. Email notifications
3. SMS notifications
4. Push notifications untuk mobile
5. Notifikasi untuk aktivitas lain (news published, user registered, dll)
6. Filter dan search di halaman notifikasi
7. Export notifikasi ke PDF/Excel
8. Notifikasi preferences per user

## Troubleshooting

### Notifikasi tidak muncul
- Pastikan tabel `notifications` sudah di-migrate
- Pastikan User model menggunakan trait `Notifiable`
- Cek apakah notifikasi berhasil disimpan di database

### Badge counter tidak update
- Refresh halaman untuk melihat update terbaru
- Implementasi real-time update menggunakan WebSocket untuk auto-refresh

### Notifikasi tidak bisa dihapus
- Pastikan route dan method controller sudah benar
- Cek permission user untuk menghapus notifikasi

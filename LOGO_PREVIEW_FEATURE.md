# Fitur Preview Logo

## Deskripsi
Fitur preview logo memungkinkan admin untuk melihat gambar yang akan diupload sebelum benar-benar menyimpannya ke sistem. Ini membantu memastikan gambar yang dipilih sesuai dengan kebutuhan sebelum upload.

## Fitur Utama

### 1. **Preview Real-time**
- Gambar ditampilkan segera setelah file dipilih
- Preview muncul dalam area khusus dengan border berwarna
- Ukuran preview disesuaikan dengan jenis logo (utama, dark mode, favicon)

### 2. **Validasi File**
- **Format yang didukung**: JPG, PNG, GIF, SVG, ICO
- **Ukuran maksimal**: 2MB per file
- **Validasi otomatis**: Peringatan jika format atau ukuran tidak sesuai

### 3. **Kontrol Upload**
- Tombol "Upload" hanya muncul setelah file dipilih dan valid
- Tombol "Batal" untuk membatalkan pilihan file
- Preview dapat dibersihkan tanpa reload halaman

## Implementasi Teknis

### Frontend (Alpine.js)
```javascript
function logoPreview() {
    return {
        previewUrl: null,
        selectedFile: null,
        
        handleFileSelect(event) {
            // Validasi file dan buat preview
        },
        
        clearPreview() {
            // Bersihkan preview dan reset input
        }
    }
}
```

### Validasi File
- **Tipe file**: Menggunakan `file.type` untuk validasi MIME type
- **Ukuran file**: Maksimal 2MB (2,097,152 bytes)
- **Error handling**: Alert untuk file yang tidak valid

### Preview Area
- **Logo Utama**: Background putih dengan border biru
- **Logo Dark Mode**: Background gelap dengan border ungu
- **Favicon**: Background putih dengan ukuran preview 64x64px

## Cara Penggunaan

### 1. **Upload Logo Baru**
1. Klik tombol "Choose File" pada jenis logo yang diinginkan
2. Pilih file gambar dari komputer
3. Preview akan muncul otomatis jika file valid
4. Klik "Upload" untuk menyimpan atau "Batal" untuk membatalkan

### 2. **Validasi Visual**
- Periksa kualitas gambar di preview
- Pastikan logo terlihat jelas dan proporsional
- Untuk logo dark mode, pastikan kontras dengan background gelap

### 3. **Error Handling**
- File format tidak didukung → Alert peringatan
- File terlalu besar → Alert ukuran maksimal
- File rusak → Preview tidak muncul

## Keuntungan

### 1. **User Experience**
- Mengurangi kesalahan upload
- Feedback visual yang jelas
- Proses upload yang lebih intuitif

### 2. **Efisiensi**
- Tidak perlu upload ulang jika gambar tidak sesuai
- Validasi sebelum proses server
- Menghemat bandwidth dan waktu

### 3. **Quality Control**
- Memastikan kualitas gambar sebelum publish
- Preview dalam konteks yang sesuai (background)
- Validasi ukuran dan format otomatis

## Kompatibilitas
- **Browser**: Modern browsers yang mendukung FileReader API
- **File Format**: JPG, PNG, GIF, SVG, ICO
- **JavaScript**: Menggunakan Alpine.js (sudah tersedia)

## Troubleshooting

### Preview Tidak Muncul
1. Pastikan file format didukung
2. Cek ukuran file (max 2MB)
3. Pastikan JavaScript aktif di browser

### File Tidak Bisa Dipilih
1. Cek permission folder upload
2. Pastikan format file sesuai
3. Restart browser jika perlu

## Update Selanjutnya
- Crop tool untuk resize gambar
- Multiple format preview
- Drag & drop upload
- Progress bar untuk upload besar
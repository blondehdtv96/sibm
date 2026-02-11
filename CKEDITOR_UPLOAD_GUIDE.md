# 📝 CKEditor Upload Guide

## ✅ Status: Ready to Use

CKEditor 5 sudah dikonfigurasi dengan fitur upload gambar!

---

## 🎯 Cara Upload Gambar

### Metode 1: Klik Icon Upload
1. Klik icon **"Upload Image"** di toolbar CKEditor
2. Pilih gambar dari komputer (max 2MB)
3. Gambar akan otomatis ter-upload dan muncul di editor

### Metode 2: Drag & Drop
1. Drag gambar dari folder komputer
2. Drop ke area editor
3. Gambar akan otomatis ter-upload

### Metode 3: Copy-Paste
1. Copy gambar (Ctrl+C)
2. Paste di editor (Ctrl+V)
3. Gambar akan otomatis ter-upload

---

## 🔧 Technical Details

### Upload Endpoint:
```
POST /admin/news/upload-image
```

### Request Format:
```
Content-Type: multipart/form-data
Field name: upload
CSRF Token: Required
```

### Response Format (Success):
```json
{
    "url": "http://127.0.0.1:8000/storage/news/content-images/1234567890_image-name.jpg",
    "uploaded": 1,
    "fileName": "1234567890_image-name.jpg"
}
```

### Response Format (Error):
```json
{
    "uploaded": 0,
    "error": {
        "message": "Upload failed: ..."
    }
}
```

---

## 📁 File Storage

### Location:
```
storage/app/public/news/content-images/
```

### Public URL:
```
http://127.0.0.1:8000/storage/news/content-images/filename.jpg
```

### Filename Format:
```
{timestamp}_{slug-name}.{extension}
Example: 1707523456_my-image.jpg
```

---

## ✅ Validation Rules

### Image Upload:
- **Required**: Yes
- **Type**: Image only (jpeg, png, jpg, gif, webp)
- **Max Size**: 2MB (2048 KB)

### File Upload (PDF, DOC, etc):
- **Required**: Yes
- **Type**: pdf, doc, docx, xls, xlsx, ppt, pptx, zip, rar
- **Max Size**: 10MB (10240 KB)

---

## 🐛 Troubleshooting

### Upload Gagal?

#### 1. Check Storage Link
```bash
php artisan storage:link
```

#### 2. Check Folder Permissions
```bash
# Windows (PowerShell)
icacls storage\app\public\news\content-images /grant Everyone:F

# Linux/Mac
chmod -R 775 storage/app/public/news
```

#### 3. Check File Size
- Pastikan gambar < 2MB
- Compress gambar jika terlalu besar

#### 4. Check Browser Console
- Buka Developer Tools (F12)
- Lihat tab Console untuk error
- Lihat tab Network untuk request/response

#### 5. Check Laravel Log
```bash
tail -f storage/logs/laravel.log
```

---

## 🧪 Manual Test Upload

### Using cURL:
```bash
curl -X POST http://127.0.0.1:8000/admin/news/upload-image \
  -H "X-CSRF-TOKEN: your-csrf-token" \
  -F "upload=@/path/to/image.jpg"
```

### Using Postman:
1. Method: POST
2. URL: `http://127.0.0.1:8000/admin/news/upload-image`
3. Headers:
   - `X-CSRF-TOKEN`: (get from page)
4. Body:
   - Type: form-data
   - Key: `upload`
   - Value: (select file)

---

## 📊 CKEditor Configuration

### Toolbar Items:
- Heading (H1-H4)
- Bold, Italic, Underline, Strikethrough
- Link
- **Upload Image** ← Upload feature
- Insert Table
- Block Quote
- Bullet List, Numbered List
- Indent, Outdent
- Alignment
- Undo, Redo
- Source Editing (HTML mode)

### Upload Config:
```javascript
simpleUpload: {
    uploadUrl: '/admin/news/upload-image',
    headers: {
        'X-CSRF-TOKEN': 'csrf-token-here'
    }
}
```

---

## 🎨 Image Features

### After Upload:
- Resize image (drag corners)
- Align image (left, center, right)
- Add alt text
- Add caption
- Delete image

### Image Styles:
- Inline (in text)
- Block (full width)
- Side (float left/right)

---

## 📝 Example Usage

### 1. Create News Article
```
1. Go to: /admin/news/create
2. Fill title, slug, excerpt
3. In Content editor:
   - Click "Upload Image" icon
   - Select image
   - Wait for upload
   - Image appears in editor
4. Continue writing content
5. Submit form
```

### 2. Edit Existing Article
```
1. Go to: /admin/news/{id}/edit
2. Content editor loads with existing content
3. Add more images as needed
4. Update article
```

---

## ⚠️ Important Notes

### 1. CSRF Token
- Automatically included in upload request
- No manual configuration needed

### 2. File Naming
- Original filename is slugified
- Timestamp prefix prevents conflicts
- Safe for URLs

### 3. Storage
- Files stored in `storage/app/public/`
- Accessible via `public/storage/` symlink
- Automatic cleanup not implemented (manual delete needed)

### 4. Security
- File type validation (only images)
- File size validation (max 2MB)
- Filename sanitization
- CSRF protection

---

## 🚀 Next Steps

### Optional Enhancements:
- [ ] Add image compression
- [ ] Add thumbnail generation
- [ ] Add image optimization
- [ ] Add bulk upload
- [ ] Add image gallery picker
- [ ] Add image cropping
- [ ] Add watermark
- [ ] Add CDN integration

---

## 📞 Need Help?

### Check:
1. Browser console (F12)
2. Network tab (check upload request)
3. Laravel log (`storage/logs/laravel.log`)
4. Server error log

### Common Issues:
- **413 Payload Too Large**: File too big, reduce size
- **422 Validation Error**: Wrong file type or missing field
- **500 Server Error**: Check Laravel log
- **CSRF Token Mismatch**: Refresh page

---

## ✅ Checklist

- [x] CKEditor 5 installed
- [x] Upload route registered
- [x] Upload controller method created
- [x] Storage folder created
- [x] Storage link exists
- [x] Validation rules set
- [x] CSRF token configured
- [x] Response format correct

---

**Status:** ✅ Ready to Use  
**Last Updated:** February 12, 2026  
**Version:** 1.0

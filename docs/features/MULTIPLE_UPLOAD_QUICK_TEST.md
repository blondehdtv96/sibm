# Quick Test Guide - Multiple Image Upload

## 🚀 Quick Test Steps

### Test 1: Single Image Upload (Backward Compatibility)
```
1. Navigate: http://localhost/admin/home-sliders/create
2. Click file input
3. Select 1 image
4. Fill form:
   - Title: "Test Single"
   - Order: 0
   - Status: Active
5. Submit
6. ✅ Expected: "Slider berhasil ditambahkan!"
```

### Test 2: Multiple Images Upload (3 images)
```
1. Navigate: http://localhost/admin/home-sliders/create
2. Click file input
3. Hold Ctrl + Select 3 images
4. Verify: Preview shows 3 images in grid
5. Fill form:
   - Title: "Test Multiple"
   - Subtitle: "Testing batch upload"
   - Order: 10
   - Status: Active
6. Submit
7. ✅ Expected: "Berhasil menambahkan 3 slider!"
8. ✅ Verify: 3 sliders created with order 10, 11, 12
```

### Test 3: Remove Individual Image
```
1. Select 5 images
2. Preview shows 5 images
3. Hover over 3rd image
4. Click X button
5. ✅ Expected: Preview now shows 4 images
6. Submit
7. ✅ Expected: "Berhasil menambahkan 4 slider!"
```

### Test 4: Clear All Images
```
1. Select 3 images
2. Preview shows 3 images
3. Click "Hapus Semua"
4. ✅ Expected: Preview hidden, file input cleared
5. Select 2 different images
6. Submit
7. ✅ Expected: "Berhasil menambahkan 2 slider!"
```

### Test 5: Validation - No Images
```
1. Navigate to create page
2. Don't select any images
3. Fill other fields
4. Submit
5. ✅ Expected: "The images field is required."
```

### Test 6: Validation - File Too Large
```
1. Select image > 5MB
2. Submit
3. ✅ Expected: "The images.0 must not be greater than 5120 kilobytes."
```

### Test 7: Validation - Wrong Format
```
1. Select .pdf or .txt file
2. Submit
3. ✅ Expected: "The images.0 must be an image."
```

### Test 8: Large Batch (10+ images)
```
1. Select 10 images at once
2. Verify: Preview shows all 10
3. Fill form with order: 100
4. Submit
5. ✅ Expected: "Berhasil menambahkan 10 slider!"
6. ✅ Verify: Orders are 100-109
```

## 🔍 Verification Checklist

### Database Check
```sql
-- Check if sliders created
SELECT id, title, order, status, created_at 
FROM home_sliders 
ORDER BY created_at DESC 
LIMIT 10;

-- Verify order sequence
SELECT id, title, order 
FROM home_sliders 
WHERE title = 'Test Multiple'
ORDER BY order;
```

### File Storage Check
```bash
# Windows CMD
dir storage\app\public\sliders

# PowerShell
Get-ChildItem storage\app\public\sliders
```

### Frontend Check
```
1. Visit: http://localhost/
2. ✅ Verify: Slider shows uploaded images
3. ✅ Verify: Auto-play works
4. ✅ Verify: Navigation works
5. ✅ Verify: Title/subtitle displays
```

## 🐛 Common Issues & Solutions

### Issue 1: Preview Not Showing
**Symptoms**: Images selected but no preview
**Solution**: 
- Check browser console for errors
- Verify JavaScript is enabled
- Clear browser cache

### Issue 2: Only First Image Uploaded
**Symptoms**: Selected 5 images, only 1 saved
**Solution**:
- Verify input name is `images[]` (with brackets)
- Check `multiple` attribute exists
- Verify controller loops through files

### Issue 3: File Upload Fails
**Symptoms**: Error on submit
**Solution**:
```ini
; Check php.ini
upload_max_filesize = 10M
post_max_size = 50M
max_file_uploads = 20
```
Restart Apache/Nginx after changes

### Issue 4: Images Not Displaying on Frontend
**Symptoms**: Sliders created but images broken
**Solution**:
```bash
# Create symbolic link
php artisan storage:link

# Verify link exists
dir public\storage
```

## 📊 Performance Test

### Test Large Batch Upload
```
Test Case: Upload 20 images (2MB each)
Expected Time: < 30 seconds
Expected Memory: < 256MB
Expected Result: All 20 sliders created successfully
```

### Monitor During Upload
```php
// Add to controller for testing
Log::info('Upload started', [
    'count' => count($request->file('images')),
    'memory' => memory_get_usage(true)
]);

// After loop
Log::info('Upload completed', [
    'uploaded' => $uploadedCount,
    'memory' => memory_get_usage(true)
]);
```

## ✅ Success Criteria

All tests should pass:
- [x] Single image upload works
- [x] Multiple images upload works
- [x] Preview displays correctly
- [x] Remove individual works
- [x] Clear all works
- [x] Validation works
- [x] Order auto-increments
- [x] Files stored correctly
- [x] Database records created
- [x] Frontend displays images
- [x] Success messages accurate

## 🎯 Quick Smoke Test (2 minutes)

```
1. Upload 3 images at once
2. Verify preview shows 3 images
3. Submit form
4. Check success message: "Berhasil menambahkan 3 slider!"
5. Visit homepage
6. Verify slider shows new images
7. ✅ PASS - Feature working!
```

---

**Test Date**: ___________  
**Tester**: ___________  
**Result**: ☐ PASS  ☐ FAIL  
**Notes**: ___________

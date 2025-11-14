# TinyMCE Rich Text Editor Implementation

## Overview
Implementasi TinyMCE WYSIWYG editor untuk semua textarea description/content di admin panel, memungkinkan formatting text seperti bold, italic, lists, links, dll.

## ✅ Implementation Status: IN PROGRESS

### What's Implemented
- TinyMCE CDN integration in admin layout
- Auto-initialization for textareas with class `tinymce`
- Updated competency description fields
- Updated news content field
- Toolbar with essential formatting options

## Features

### Formatting Options
- **Text Formatting**: Bold, Italic, Underline, Strikethrough
- **Alignment**: Left, Center, Right, Justify
- **Lists**: Bulleted list, Numbered list
- **Indentation**: Indent, Outdent
- **Undo/Redo**: Full history support
- **Blocks**: Paragraph, Headings (H1-H6)
- **Remove Format**: Clear all formatting
- **Help**: Built-in help documentation

### Plugins Included
```javascript
plugins: [
    'advlist',        // Advanced list styles
    'autolink',       // Auto-detect URLs
    'lists',          // List management
    'link',           // Insert/edit links
    'image',          // Insert/edit images
    'charmap',        // Special characters
    'preview',        // Preview content
    'anchor',         // Anchor points
    'searchreplace',  // Find and replace
    'visualblocks',   // Show block elements
    'code',           // View HTML code
    'fullscreen',     // Fullscreen mode
    'insertdatetime', // Insert date/time
    'media',          // Embed media
    'table',          // Table management
    'help',           // Help documentation
    'wordcount'       // Word counter
]
```

## Technical Implementation

### 1. Admin Layout Integration
**File**: `resources/views/layouts/admin-modern.blade.php`

**Added before @stack('scripts')**:
```html
<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: 'textarea.tinymce',
                height: 400,
                menubar: false,
                plugins: [...],
                toolbar: '...',
                content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; }',
                branding: false,
                promotion: false,
            });
        }
    });
</script>
```

### 2. Usage in Forms
**Before**:
```html
<textarea 
    id="description" 
    name="description" 
    rows="15" 
    class="w-full px-4 py-2 border border-gray-300 rounded-lg..."
>{{ old('description') }}</textarea>
```

**After**:
```html
<textarea 
    id="description" 
    name="description" 
    class="tinymce"
>{{ old('description') }}</textarea>
```

**Key Changes**:
- Remove `rows` attribute (TinyMCE sets height)
- Remove styling classes (TinyMCE handles styling)
- Add `tinymce` class for auto-initialization

### 3. Frontend Display
**Before**:
```blade
{!! nl2br(e($competency->description)) !!}
```

**After**:
```blade
{!! $competency->description !!}
```

**Note**: Remove `nl2br()` and `e()` since content is already HTML formatted

## Files Updated

### Completed ✅
1. `resources/views/layouts/admin-modern.blade.php` - TinyMCE integration
2. `resources/views/admin/competencies/create.blade.php` - Description field
3. `resources/views/admin/competencies/edit.blade.php` - Description field
4. `resources/views/public/competencies/show.blade.php` - Display HTML content
5. `resources/views/admin/news/create.blade.php` - Content field

### To Update 📝
1. `resources/views/admin/news/edit.blade.php` - Content & excerpt
2. `resources/views/admin/pages/create.blade.php` - Content
3. `resources/views/admin/pages/edit.blade.php` - Content
4. `resources/views/admin/settings/school-content.blade.php` - Overview & principal message
5. `resources/views/admin/gallery-albums/create.blade.php` - Description
6. `resources/views/admin/gallery-albums/edit.blade.php` - Description
7. `resources/views/admin/competencies/create.blade.php` - Head of program message
8. `resources/views/admin/competencies/edit.blade.php` - Head of program message

## Update Instructions

### For Each Textarea:

#### Step 1: Update the Textarea
```html
<!-- Find -->
<textarea 
    id="field_name" 
    name="field_name" 
    rows="15" 
    class="w-full px-4 py-2 border..."
>{{ old('field_name') }}</textarea>

<!-- Replace with -->
<textarea 
    id="field_name" 
    name="field_name" 
    class="tinymce"
>{{ old('field_name') }}</textarea>
```

#### Step 2: Update Frontend Display
```blade
<!-- Find -->
{!! nl2br(e($model->field_name)) !!}

<!-- Replace with -->
{!! $model->field_name !!}
```

## Configuration Options

### Current Configuration
```javascript
{
    selector: 'textarea.tinymce',
    height: 400,
    menubar: false,
    plugins: [...],
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
             'alignleft aligncenter alignright alignjustify | ' +
             'bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family: Inter, sans-serif; font-size: 14px; }',
    branding: false,
    promotion: false,
}
```

### Customization Options

#### Change Height
```javascript
height: 500,  // pixels
```

#### Add More Toolbar Buttons
```javascript
toolbar: 'undo redo | blocks | bold italic underline | ' +
         'forecolor backcolor | link image | code fullscreen'
```

#### Enable Menubar
```javascript
menubar: true,  // or 'file edit view insert format tools table help'
```

#### Add Custom Styles
```javascript
style_formats: [
    {title: 'Headers', items: [
        {title: 'Header 1', format: 'h1'},
        {title: 'Header 2', format: 'h2'},
        {title: 'Header 3', format: 'h3'}
    ]},
    {title: 'Inline', items: [
        {title: 'Bold', format: 'bold'},
        {title: 'Italic', format: 'italic'}
    ]}
]
```

## Security Considerations

### XSS Protection
**Important**: When displaying HTML content, ensure proper sanitization

**Current Approach**:
```blade
{!! $model->field_name !!}
```

**Recommended**: Use HTML Purifier for production
```bash
composer require mews/purifier
```

```php
// In Model
public function getDescriptionAttribute($value)
{
    return clean($value);
}
```

### Content Security Policy
If using CSP, allow TinyMCE CDN:
```html
<meta http-equiv="Content-Security-Policy" 
      content="script-src 'self' https://cdn.tiny.cloud;">
```

## Browser Support

### Supported Browsers
- ✅ Chrome/Edge 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Opera 76+

### Mobile Support
- ✅ iOS Safari 14+
- ✅ Chrome Mobile 90+
- ⚠️ Limited on small screens (recommend desktop for editing)

## Performance

### Load Time
- TinyMCE CDN: ~200KB (gzipped)
- Initial load: ~500ms
- Subsequent loads: Cached

### Optimization Tips
```javascript
// Lazy load TinyMCE
tinymce.init({
    selector: 'textarea.tinymce',
    lazy_load_css: true,
    // ... other options
});
```

## Troubleshooting

### Issue: Editor not loading
**Solution**:
1. Check browser console for errors
2. Verify CDN is accessible
3. Ensure `tinymce` class is added to textarea
4. Check if JavaScript is enabled

### Issue: Content not saving
**Solution**:
1. TinyMCE auto-saves to textarea on form submit
2. Verify form has `enctype="multipart/form-data"` if uploading images
3. Check server-side validation

### Issue: Styling not applied on frontend
**Solution**:
1. Ensure using `{!! $content !!}` not `{{ $content }}`
2. Add prose classes for better styling:
```html
<div class="prose prose-lg max-w-none">
    {!! $content !!}
</div>
```

### Issue: Images not uploading
**Solution**:
TinyMCE free version doesn't include image upload. Options:
1. Use external image hosting
2. Implement custom image upload handler
3. Upgrade to TinyMCE premium

## Advanced Features

### Custom Image Upload
```javascript
tinymce.init({
    selector: 'textarea.tinymce',
    images_upload_url: '/admin/upload-image',
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/upload-image');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        
        xhr.onload = function() {
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            var json = JSON.parse(xhr.responseText);
            success(json.location);
        };
        
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }
});
```

### Auto-save Draft
```javascript
tinymce.init({
    selector: 'textarea.tinymce',
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: 'tinymce-autosave-{path}{query}-{id}-',
    autosave_restore_when_empty: true,
});
```

### Word Count
```javascript
tinymce.init({
    selector: 'textarea.tinymce',
    plugins: 'wordcount',
    statusbar: true,
});
```

## Testing Checklist

### Functionality
- [ ] Editor loads on page
- [ ] Can type and format text
- [ ] Bold/Italic/Underline works
- [ ] Lists work (bulleted/numbered)
- [ ] Alignment works
- [ ] Undo/Redo works
- [ ] Content saves correctly
- [ ] Content displays correctly on frontend
- [ ] HTML is properly formatted

### Cross-browser
- [ ] Chrome/Edge
- [ ] Firefox
- [ ] Safari
- [ ] Mobile browsers

### Security
- [ ] XSS protection in place
- [ ] HTML sanitization working
- [ ] No script injection possible

## Migration Guide

### For Existing Content

If you have existing content with line breaks (`\n`), you need to convert:

```php
// In migration or seeder
DB::table('competencies')->get()->each(function ($competency) {
    DB::table('competencies')
        ->where('id', $competency->id)
        ->update([
            'description' => nl2br(e($competency->description))
        ]);
});
```

Or handle in model accessor:
```php
public function getDescriptionAttribute($value)
{
    // If content doesn't have HTML tags, convert line breaks
    if (strip_tags($value) === $value) {
        return nl2br(e($value));
    }
    return $value;
}
```

## Alternative Editors

If TinyMCE doesn't meet your needs:

### CKEditor
```html
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('.editor'));
</script>
```

### Quill
```html
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
    var quill = new Quill('.editor', { theme: 'snow' });
</script>
```

### Summernote
```html
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('.editor').summernote();
</script>
```

## Summary

### Benefits
- ✅ Rich text formatting
- ✅ User-friendly interface
- ✅ No additional dependencies
- ✅ Free to use
- ✅ Well documented
- ✅ Active development

### Limitations
- ⚠️ Requires internet (CDN)
- ⚠️ Free version has limited features
- ⚠️ No built-in image upload
- ⚠️ Larger page size

### Status
**🔄 IN PROGRESS**

**Completed**:
- TinyMCE integration
- Competency description
- News content
- Frontend display

**Remaining**:
- Other content fields
- Image upload handler
- HTML sanitization
- Testing

---

**Implementation Date**: January 14, 2025  
**Version**: 1.0.0  
**Editor**: TinyMCE 6  
**Status**: In Progress

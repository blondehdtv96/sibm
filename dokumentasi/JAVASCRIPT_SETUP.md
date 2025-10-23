# JavaScript Components Setup Guide

This guide explains how to set up and use the interactive JavaScript components in the Laravel School Management System.

## Installation

### 1. Install Dependencies

```bash
npm install
```

This will install:
- Alpine.js (v3.13.5) - Reactive JavaScript framework
- Vite (v5.0.0) - Build tool and dev server
- Laravel Vite Plugin - Integration with Laravel
- Axios - HTTP client

### 2. Build Assets

For development:
```bash
npm run dev
```

For production:
```bash
npm run build
```

## File Structure

```
resources/
├── js/
│   ├── app.js                    # Main entry point
│   ├── ios16.js                  # Core iOS 16 components
│   └── alpine-components.js      # Alpine.js components
└── css/
    └── ios16/
        ├── base.css              # Base styles
        ├── cards.css             # Card components
        ├── animations.css        # Animations
        ├── components.css        # UI components
        ├── interactions.css      # Basic interactions
        ├── touch-interactions.css # Touch gestures
        └── transitions.css       # Page transitions
```

## Usage in Blade Templates

### Basic Setup

Include Vite directive in your layout:

```blade
<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/ios16.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Your content -->
</body>
</html>
```

### Using Alpine.js Components

#### Image Gallery

```blade
<div x-data="imageGallery([
    { url: '{{ asset('images/photo1.jpg') }}', title: 'Photo 1' },
    { url: '{{ asset('images/photo2.jpg') }}', title: 'Photo 2' }
])">
    <img :src="currentImage.url" :alt="currentImage.title" class="w-full">
    <div class="ios-flex ios-justify-between ios-mt-md">
        <button @click="previous" class="ios-button ios-button-secondary">Previous</button>
        <span x-text="`${currentIndex + 1} / ${images.length}`"></span>
        <button @click="next" class="ios-button ios-button-secondary">Next</button>
    </div>
</div>
```

#### Search Component

```blade
<div x-data="searchComponent('{{ route('api.search') }}', 2)">
    <input 
        type="search" 
        x-model="query" 
        placeholder="Search..." 
        class="ios-input"
    >
    <div x-show="loading" class="ios-spinner"></div>
    <div x-show="showResults">
        <template x-for="result in results" :key="result.id">
            <a :href="result.url" x-text="result.title"></a>
        </template>
    </div>
</div>
```

#### File Upload

```blade
<form x-data="fileUpload({ maxFiles: 5, maxSize: 5242880 })">
    @csrf
    <div class="upload-zone">
        <input 
            type="file" 
            @change="addFiles($event.target.files)" 
            multiple 
            accept="image/*"
        >
        <p>Drag files here or click to browse</p>
    </div>
    
    <template x-for="file in files" :key="file.id">
        <div class="file-item">
            <img :src="file.preview" x-show="file.preview">
            <span x-text="file.name"></span>
            <button @click="removeFile(file.id)" type="button">Remove</button>
        </div>
    </template>
    
    <button 
        @click="uploadFiles('{{ route('upload') }}')" 
        type="button"
        :disabled="files.length === 0"
    >
        Upload
    </button>
</form>
```

#### Form Validation

```blade
<form x-data="formValidation()" @submit.prevent="isValid() && $el.submit()">
    @csrf
    <div>
        <input 
            type="email" 
            name="email"
            x-model="email"
            @blur="touch('email'); validate('email', email, 'required|email')"
            :class="{ 'error': hasError('email') }"
        >
        <span x-show="hasError('email')" x-text="getError('email')" class="error-message"></span>
    </div>
    
    <button type="submit" :disabled="!isValid()">Submit</button>
</form>
```

#### Notifications

```blade
<div x-data="notifications()" class="notification-container">
    <!-- Trigger notifications -->
    <button @click="add('Success!', 'success', 5000)">Show Success</button>
    
    <!-- Notification display -->
    <div class="notifications">
        <template x-for="notification in notifications" :key="notification.id">
            <div 
                x-show="notification.visible"
                x-transition
                :class="`notification notification-${notification.type}`"
            >
                <span x-text="notification.message"></span>
                <button @click="remove(notification.id)">×</button>
            </div>
        </template>
    </div>
</div>
```

### Touch Interactions

#### Swipe Gestures

```blade
<div 
    data-swipe 
    @swipe-left="handleSwipeLeft()"
    @swipe-right="handleSwipeRight()"
    class="swipeable-content"
>
    Swipe me left or right
</div>
```

#### Long Press

```blade
<button 
    data-long-press 
    @long-press="handleLongPress()"
    class="ios-button"
>
    Long press me
</button>
```

#### Pull to Refresh

```blade
<div data-pull-refresh @pull-refresh="refreshData()">
    <div class="pull-refresh-indicator">
        <div class="spinner"></div>
    </div>
    <!-- Your content -->
</div>
```

### Loading States

#### Button Loading

```blade
<button 
    class="ios-button" 
    data-loading 
    data-loading-text="Saving..."
    onclick="this.form.submit()"
>
    Save Changes
</button>
```

#### Progress Bar

```blade
<div class="ios-progress">
    <div class="ios-progress-bar" style="width: {{ $progress }}%"></div>
</div>
```

#### Skeleton Loading

```blade
@if($loading)
    <div class="skeleton skeleton-card"></div>
    <div class="skeleton skeleton-text"></div>
    <div class="skeleton skeleton-text"></div>
@else
    <!-- Actual content -->
@endif
```

### Page Transitions

Automatic for all internal links:

```blade
<a href="{{ route('dashboard') }}">Dashboard</a>
```

Disable for specific links:

```blade
<a href="{{ route('external') }}" data-no-transition>No Transition</a>
```

### Toast Notifications

Using JavaScript:

```blade
<button onclick="iOS16Utils.showToast('Success!', 'success')">
    Show Toast
</button>
```

Using Laravel session:

```php
// In controller
return redirect()->back()->with('success', 'Operation completed!');
```

```blade
@if(session('success'))
    <script>
        iOS16Utils.showToast('{{ session('success') }}', 'success');
    </script>
@endif
```

## JavaScript API

### Global Utilities

```javascript
// Toast notifications
iOS16Utils.showToast(message, type, duration);

// Haptic feedback
iOS16Utils.hapticFeedback('light'); // light, medium, heavy

// Format file size
iOS16Utils.formatFileSize(bytes);

// Debounce function
const debouncedFn = iOS16Utils.debounce(fn, wait);

// Throttle function
const throttledFn = iOS16Utils.throttle(fn, limit);
```

### Page Loading

```javascript
// Show page loader
showPageLoading();

// Hide page loader
hidePageLoading();
```

### Button Loading

```javascript
// Show button loading
showButtonLoading(buttonElement);

// Hide button loading
hideButtonLoading(buttonElement);
```

### Lightbox

```javascript
// Show lightbox
showLightbox(imageSrc, imageAlt);
```

## Events

### Custom Events

```javascript
// Swipe events
element.addEventListener('swipe-left', (e) => {
    console.log('Swiped left', e.detail);
});

element.addEventListener('swipe-right', (e) => {
    console.log('Swiped right', e.detail);
});

// Long press
element.addEventListener('long-press', () => {
    console.log('Long pressed');
});

// Pull refresh
element.addEventListener('pull-refresh', () => {
    console.log('Pull to refresh triggered');
});
```

### Alpine Events

```javascript
// Listen to Alpine events
document.addEventListener('result-selected', (e) => {
    console.log('Search result selected', e.detail);
});

document.addEventListener('upload-success', (e) => {
    console.log('Files uploaded', e.detail);
});

document.addEventListener('auto-saved', () => {
    console.log('Form auto-saved');
});
```

## Customization

### Modifying Components

Edit component files:
- `resources/js/ios16.js` - Core components
- `resources/js/alpine-components.js` - Alpine components

### Adding New Components

1. Create component in `alpine-components.js`:

```javascript
Alpine.data('myComponent', () => ({
    // Component data and methods
    init() {
        // Initialization code
    }
}));
```

2. Use in Blade:

```blade
<div x-data="myComponent()">
    <!-- Component template -->
</div>
```

### Styling

Modify CSS files in `resources/css/ios16/`:
- `touch-interactions.css` - Touch styles
- `transitions.css` - Animation styles
- `components.css` - Component styles

## Troubleshooting

### Alpine.js not working

1. Check browser console for errors
2. Ensure Vite is running (`npm run dev`)
3. Clear browser cache
4. Verify `@vite` directive in layout

### Touch gestures not working

1. Ensure element has `data-swipe` attribute
2. Check if touch events are being blocked
3. Verify iOS 16 JS is loaded

### Styles not applying

1. Run `npm run build`
2. Clear Laravel cache: `php artisan cache:clear`
3. Hard refresh browser (Ctrl+Shift+R)

### Build errors

1. Delete `node_modules` and `package-lock.json`
2. Run `npm install` again
3. Check Node.js version (16+ required)

## Performance Tips

1. **Lazy load images**: Use `data-src` with intersection observer
2. **Debounce scroll events**: Already implemented in core
3. **Use CSS transforms**: For smooth animations
4. **Minimize Alpine watchers**: Only watch what's necessary
5. **Code splitting**: Vite handles this automatically

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- iOS Safari 14+
- Android Chrome 90+

## Additional Resources

- [Alpine.js Documentation](https://alpinejs.dev/)
- [Vite Documentation](https://vitejs.dev/)
- [Laravel Vite Documentation](https://laravel.com/docs/vite)
- [INTERACTIVE_COMPONENTS.md](INTERACTIVE_COMPONENTS.md) - Component reference

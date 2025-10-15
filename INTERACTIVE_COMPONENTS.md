# Interactive Components Documentation

This document describes all the interactive JavaScript components available in the iOS 16 Design System.

## Table of Contents

1. [Alpine.js Components](#alpinejs-components)
2. [Touch Interactions](#touch-interactions)
3. [Page Transitions](#page-transitions)
4. [Loading States](#loading-states)
5. [Usage Examples](#usage-examples)

## Alpine.js Components

### Image Gallery

A swipe-enabled image gallery with keyboard navigation support.

```html
<div x-data="imageGallery([
    { url: '/path/to/image1.jpg', title: 'Image 1' },
    { url: '/path/to/image2.jpg', title: 'Image 2' }
])">
    <img :src="currentImage.url" :alt="currentImage.title">
    <button @click="previous">Previous</button>
    <button @click="next">Next</button>
</div>
```

**Features:**
- Swipe gestures (left/right)
- Keyboard navigation (arrow keys)
- Touch-friendly controls
- Automatic image preloading

### Search Component

Live search with debouncing and result display.

```html
<div x-data="searchComponent('/api/search', 2)">
    <input type="search" x-model="query" placeholder="Search...">
    <div x-show="showResults">
        <template x-for="result in results">
            <div @click="selectResult(result)" x-text="result.title"></div>
        </template>
    </div>
</div>
```

**Features:**
- Debounced search (300ms)
- Minimum character length
- Loading indicator
- Click-outside to close

### File Upload

Drag-and-drop file upload with preview.

```html
<div x-data="fileUpload({ maxFiles: 5, maxSize: 5242880, acceptedTypes: ['image/*'] })">
    <input type="file" @change="addFiles($event.target.files)" multiple>
    <template x-for="file in files">
        <div>
            <img :src="file.preview">
            <button @click="removeFile(file.id)">Remove</button>
        </div>
    </template>
</div>
```

**Features:**
- Drag and drop support
- File type validation
- Size validation
- Image preview generation
- Multiple file support

### Notifications

Toast-style notifications system.

```html
<div x-data="notifications()">
    <button @click="add('Success!', 'success')">Show Notification</button>
</div>
```

**Methods:**
- `add(message, type, duration)` - Add notification
- `remove(id)` - Remove specific notification
- `clear()` - Clear all notifications

### Form Validation

Client-side form validation with custom rules.

```html
<div x-data="formValidation()">
    <input 
        type="email" 
        x-model="email"
        @blur="validate('email', email, 'required|email')"
    >
    <span x-show="hasError('email')" x-text="getError('email')"></span>
</div>
```

**Validation Rules:**
- `required` - Field must not be empty
- `email` - Valid email format
- `min:n` - Minimum n characters
- `max:n` - Maximum n characters
- `numeric` - Must be a number
- `url` - Valid URL format

### Data Table

Sortable, searchable, paginated data table.

```html
<div x-data="dataTable(data, { perPage: 10, defaultSort: 'name' })">
    <input type="search" x-model="searchQuery" placeholder="Search...">
    <table>
        <thead>
            <tr>
                <th @click="sort('name')">Name</th>
                <th @click="sort('email')">Email</th>
            </tr>
        </thead>
        <tbody>
            <template x-for="item in paginatedData">
                <tr>
                    <td x-text="item.name"></td>
                    <td x-text="item.email"></td>
                </tr>
            </template>
        </tbody>
    </table>
</div>
```

### Loading State

Manage loading states for async operations.

```html
<div x-data="loadingState()">
    <button 
        @click="withLoading(async () => { await fetchData(); })"
        :disabled="loading"
    >
        <span x-show="!loading">Load Data</span>
        <span x-show="loading">Loading...</span>
    </button>
</div>
```

### Clipboard

Copy text to clipboard with feedback.

```html
<div x-data="clipboard()">
    <button @click="copy('Text to copy')">
        <span x-show="!copied">Copy</span>
        <span x-show="copied">Copied!</span>
    </button>
</div>
```

## Touch Interactions

### Touch Feedback

Automatic touch feedback for interactive elements.

```html
<button class="ios-button">Tap Me</button>
```

**Features:**
- Visual scale feedback
- Haptic feedback (on supported devices)
- Prevents double-tap zoom
- Touch-active state

### Swipe Gestures

Detect swipe gestures in any direction.

```html
<div data-swipe 
     @swipe-left="handleSwipeLeft()"
     @swipe-right="handleSwipeRight()">
    Swipe me
</div>
```

**Events:**
- `swipe-left` - Swipe left detected
- `swipe-right` - Swipe right detected
- `swipe-up` - Swipe up detected
- `swipe-down` - Swipe down detected

### Long Press

Detect long press gestures.

```html
<button data-long-press @long-press="handleLongPress()">
    Long press me
</button>
```

**Features:**
- 500ms threshold
- Haptic feedback
- Cancels on movement
- Touch-friendly

### Pull to Refresh

Pull-to-refresh functionality.

```html
<div data-pull-refresh @pull-refresh="refreshData()">
    <div class="pull-refresh-indicator">
        <div class="spinner"></div>
    </div>
    <!-- Content -->
</div>
```

## Page Transitions

### Smooth Navigation

Automatic smooth transitions between pages.

```html
<!-- Automatic for all internal links -->
<a href="/page">Navigate</a>

<!-- Disable for specific links -->
<a href="/page" data-no-transition>No Transition</a>
```

### Loading Indicator

Global page loading indicator.

```javascript
// Show loading
showPageLoading();

// Hide loading
hidePageLoading();
```

### Modal Transitions

Smooth modal open/close animations.

```html
<button data-modal-target="myModal">Open Modal</button>

<div id="myModal" class="ios-modal">
    <div class="modal-content">
        <button data-modal-close>Close</button>
        <!-- Modal content -->
    </div>
</div>
```

### Toast Notifications

Show temporary notifications.

```javascript
// Using utility function
iOS16Utils.showToast('Message', 'success', 3000);

// Types: success, error, warning, info
```

## Loading States

### Button Loading

Show loading state on buttons.

```html
<button class="ios-button" data-loading data-loading-text="Saving...">
    Save
</button>
```

### Progress Bar

Display progress for long operations.

```html
<div class="ios-progress">
    <div class="ios-progress-bar" style="width: 50%"></div>
</div>

<!-- Indeterminate progress -->
<div class="ios-progress">
    <div class="ios-progress-bar indeterminate"></div>
</div>
```

### Skeleton Loading

Show skeleton placeholders while loading.

```html
<div class="skeleton skeleton-text"></div>
<div class="skeleton skeleton-avatar"></div>
<div class="skeleton skeleton-card"></div>
```

## Usage Examples

### Complete Form with Validation

```html
<form x-data="formValidation()" @submit.prevent="isValid() && submitForm()">
    <div>
        <input 
            type="email" 
            x-model="email"
            @blur="touch('email'); validate('email', email, 'required|email')"
        >
        <span x-show="hasError('email')" x-text="getError('email')"></span>
    </div>
    
    <button type="submit" :disabled="!isValid()">Submit</button>
</form>
```

### Image Gallery with Lightbox

```html
<div x-data="imageGallery(images)">
    <img 
        :src="currentImage.url" 
        data-lightbox
        @click="/* Lightbox opens automatically */"
    >
    <div class="ios-flex ios-justify-between">
        <button @click="previous">←</button>
        <button @click="next">→</button>
    </div>
</div>
```

### Search with Results

```html
<div x-data="searchComponent('/api/search')">
    <input type="search" x-model="query" placeholder="Search...">
    
    <div x-show="loading">Searching...</div>
    
    <div x-show="showResults && results.length > 0">
        <template x-for="result in results">
            <a :href="result.url" x-text="result.title"></a>
        </template>
    </div>
    
    <div x-show="showResults && results.length === 0">
        No results found
    </div>
</div>
```

### Infinite Scroll

```html
<div x-data="infiniteScroll({ endpoint: '/api/items' })">
    <div id="items-container">
        <!-- Items will be loaded here -->
    </div>
    
    <div x-show="loading">Loading more...</div>
    <div x-show="!hasMore">No more items</div>
</div>
```

## Keyboard Shortcuts

The system includes built-in keyboard shortcuts:

- `Cmd/Ctrl + K` - Focus search input
- `Escape` - Close modals/dropdowns/clear search
- `Arrow Keys` - Navigate galleries
- `Tab` - Enable keyboard navigation mode

## Accessibility

All components include:

- ARIA labels and roles
- Keyboard navigation support
- Focus management
- Screen reader support
- High contrast mode support

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- iOS Safari 12+
- Android Chrome 80+
- Progressive enhancement for older browsers

## Performance

- Debounced scroll and resize events
- Throttled touch events
- Lazy loading for images
- Efficient DOM updates with Alpine.js
- CSS transforms for animations (GPU accelerated)

## Mobile Optimization

- Touch-friendly hit areas (minimum 44x44px)
- Haptic feedback on supported devices
- Smooth scrolling with momentum
- Safe area insets for notched devices
- Optimized for touch gestures

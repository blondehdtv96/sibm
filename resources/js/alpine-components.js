/**
 * Alpine.js Components for iOS 16 Design System
 * Custom Alpine.js components and directives
 */

// Wait for Alpine to be available
if (typeof window.Alpine !== 'undefined') {
    initializeAlpineComponents();
} else {
    document.addEventListener('alpine:init', initializeAlpineComponents);
}

function initializeAlpineComponents() {
    if (typeof Alpine === 'undefined') return;
    Alpine.data('imageGallery', (images = []) => ({
        images: images,
        currentIndex: 0,
        
        get currentImage() {
            return this.images[this.currentIndex] || null;
        },
        
        next() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        
        previous() {
            this.currentIndex = this.currentIndex === 0 ? this.images.length - 1 : this.currentIndex - 1;
        },
        
        goTo(index) {
            this.currentIndex = index;
        },
        
        init() {
            // Handle keyboard navigation
            this.$el.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight') this.next();
                if (e.key === 'ArrowLeft') this.previous();
            });
            
            // Handle swipe gestures
            this.$el.addEventListener('swipe-left', () => this.next());
            this.$el.addEventListener('swipe-right', () => this.previous());
        }
    }));
    
    // Search Component
    Alpine.data('searchComponent', (endpoint = '', minLength = 2) => ({
        query: '',
        results: [],
        loading: false,
        showResults: false,
        
        async search() {
            if (this.query.length < minLength) {
                this.results = [];
                this.showResults = false;
                return;
            }
            
            this.loading = true;
            
            try {
                const response = await fetch(`${endpoint}?q=${encodeURIComponent(this.query)}`);
                const data = await response.json();
                this.results = data.results || [];
                this.showResults = true;
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },
        
        selectResult(result) {
            this.query = result.title || result.name || '';
            this.showResults = false;
            this.$dispatch('result-selected', result);
        },
        
        clearSearch() {
            this.query = '';
            this.results = [];
            this.showResults = false;
        },
        
        init() {
            // Debounced search
            this.$watch('query', Alpine.debounce(() => {
                this.search();
            }, 300));
            
            // Close results when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.$el.contains(e.target)) {
                    this.showResults = false;
                }
            });
        }
    }));
    
    // File Upload Component
    Alpine.data('fileUpload', (options = {}) => ({
        files: [],
        dragOver: false,
        uploading: false,
        progress: 0,
        maxFiles: options.maxFiles || 5,
        maxSize: options.maxSize || 5 * 1024 * 1024, // 5MB
        acceptedTypes: options.acceptedTypes || ['image/*'],
        
        addFiles(fileList) {
            const newFiles = Array.from(fileList).filter(file => {
                // Check file type
                const isValidType = this.acceptedTypes.some(type => {
                    if (type.endsWith('/*')) {
                        return file.type.startsWith(type.slice(0, -1));
                    }
                    return file.type === type;
                });
                
                // Check file size
                const isValidSize = file.size <= this.maxSize;
                
                return isValidType && isValidSize;
            });
            
            // Limit total files
            const availableSlots = this.maxFiles - this.files.length;
            const filesToAdd = newFiles.slice(0, availableSlots);
            
            filesToAdd.forEach(file => {
                const fileObj = {
                    file: file,
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    preview: null,
                    id: Date.now() + Math.random()
                };
                
                // Generate preview for images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        fileObj.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
                
                this.files.push(fileObj);
            });
        },
        
        removeFile(fileId) {
            this.files = this.files.filter(f => f.id !== fileId);
        },
        
        async uploadFiles(endpoint) {
            if (this.files.length === 0) return;
            
            this.uploading = true;
            this.progress = 0;
            
            const formData = new FormData();
            this.files.forEach((fileObj, index) => {
                formData.append(`files[${index}]`, fileObj.file);
            });
            
            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                if (response.ok) {
                    const result = await response.json();
                    this.$dispatch('upload-success', result);
                    this.files = [];
                } else {
                    throw new Error('Upload failed');
                }
            } catch (error) {
                this.$dispatch('upload-error', error);
            } finally {
                this.uploading = false;
                this.progress = 0;
            }
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },
        
        init() {
            // Handle drag and drop
            this.$el.addEventListener('dragover', (e) => {
                e.preventDefault();
                this.dragOver = true;
            });
            
            this.$el.addEventListener('dragleave', (e) => {
                e.preventDefault();
                this.dragOver = false;
            });
            
            this.$el.addEventListener('drop', (e) => {
                e.preventDefault();
                this.dragOver = false;
                this.addFiles(e.dataTransfer.files);
            });
        }
    }));
    
    // Notification Component
    Alpine.data('notifications', () => ({
        notifications: [],
        
        add(message, type = 'info', duration = 5000) {
            const notification = {
                id: Date.now() + Math.random(),
                message,
                type,
                duration,
                visible: false
            };
            
            this.notifications.push(notification);
            
            // Animate in
            this.$nextTick(() => {
                notification.visible = true;
            });
            
            // Auto remove
            if (duration > 0) {
                setTimeout(() => {
                    this.remove(notification.id);
                }, duration);
            }
            
            return notification.id;
        },
        
        remove(id) {
            const notification = this.notifications.find(n => n.id === id);
            if (notification) {
                notification.visible = false;
                setTimeout(() => {
                    this.notifications = this.notifications.filter(n => n.id !== id);
                }, 300);
            }
        },
        
        clear() {
            this.notifications.forEach(n => n.visible = false);
            setTimeout(() => {
                this.notifications = [];
            }, 300);
        }
    }));
    
    // Form Validation Component
    Alpine.data('formValidation', () => ({
        errors: {},
        touched: {},
        
        validate(field, value, rules) {
            const fieldErrors = [];
            
            if (!rules) return fieldErrors;
            
            const ruleList = rules.split('|');
            
            for (const rule of ruleList) {
                const [ruleName, ruleValue] = rule.split(':');
                
                switch (ruleName) {
                    case 'required':
                        if (!value || value.toString().trim() === '') {
                            fieldErrors.push('This field is required');
                        }
                        break;
                    case 'email':
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (value && !emailRegex.test(value)) {
                            fieldErrors.push('Please enter a valid email address');
                        }
                        break;
                    case 'min':
                        if (value && value.toString().length < parseInt(ruleValue)) {
                            fieldErrors.push(`Minimum ${ruleValue} characters required`);
                        }
                        break;
                    case 'max':
                        if (value && value.toString().length > parseInt(ruleValue)) {
                            fieldErrors.push(`Maximum ${ruleValue} characters allowed`);
                        }
                        break;
                    case 'numeric':
                        if (value && isNaN(value)) {
                            fieldErrors.push('This field must be a number');
                        }
                        break;
                    case 'url':
                        const urlRegex = /^https?:\/\/.+/;
                        if (value && !urlRegex.test(value)) {
                            fieldErrors.push('Please enter a valid URL');
                        }
                        break;
                }
            }
            
            this.errors[field] = fieldErrors;
            return fieldErrors;
        },
        
        touch(field) {
            this.touched[field] = true;
        },
        
        hasError(field) {
            return this.touched[field] && this.errors[field] && this.errors[field].length > 0;
        },
        
        getError(field) {
            return this.hasError(field) ? this.errors[field][0] : '';
        },
        
        isValid() {
            return Object.values(this.errors).every(errors => errors.length === 0);
        },
        
        reset() {
            this.errors = {};
            this.touched = {};
        }
    }));
    
    // Data Table Component
    Alpine.data('dataTable', (data = [], options = {}) => ({
        data: data,
        filteredData: data,
        sortColumn: options.defaultSort || '',
        sortDirection: options.defaultDirection || 'asc',
        searchQuery: '',
        currentPage: 1,
        perPage: options.perPage || 10,
        
        get totalPages() {
            return Math.ceil(this.filteredData.length / this.perPage);
        },
        
        get paginatedData() {
            const start = (this.currentPage - 1) * this.perPage;
            const end = start + this.perPage;
            return this.filteredData.slice(start, end);
        },
        
        sort(column) {
            if (this.sortColumn === column) {
                this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortColumn = column;
                this.sortDirection = 'asc';
            }
            
            this.filteredData.sort((a, b) => {
                let aVal = a[column];
                let bVal = b[column];
                
                if (typeof aVal === 'string') {
                    aVal = aVal.toLowerCase();
                    bVal = bVal.toLowerCase();
                }
                
                if (this.sortDirection === 'asc') {
                    return aVal > bVal ? 1 : -1;
                } else {
                    return aVal < bVal ? 1 : -1;
                }
            });
            
            this.currentPage = 1;
        },
        
        search() {
            if (!this.searchQuery) {
                this.filteredData = this.data;
            } else {
                const query = this.searchQuery.toLowerCase();
                this.filteredData = this.data.filter(item => {
                    return Object.values(item).some(value => 
                        value.toString().toLowerCase().includes(query)
                    );
                });
            }
            this.currentPage = 1;
        },
        
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        
        init() {
            this.$watch('searchQuery', () => {
                this.search();
            });
        }
    }));

    // Loading State Component
    Alpine.data('loadingState', () => ({
        loading: false,
        
        startLoading() {
            this.loading = true;
        },
        
        stopLoading() {
            this.loading = false;
        },
        
        async withLoading(asyncFunction) {
            this.startLoading();
            try {
                const result = await asyncFunction();
                return result;
            } finally {
                this.stopLoading();
            }
        }
    }));
    
    // Page Transition Component
    Alpine.data('pageTransition', () => ({
        transitioning: false,
        
        async navigateTo(url, options = {}) {
            if (this.transitioning) return;
            
            this.transitioning = true;
            document.body.classList.add('page-transitioning');
            
            // Add exit animation delay
            await new Promise(resolve => setTimeout(resolve, options.delay || 200));
            
            if (options.newTab) {
                window.open(url, '_blank');
                this.transitioning = false;
                document.body.classList.remove('page-transitioning');
            } else {
                window.location.href = url;
            }
        },
        
        init() {
            // Add enter animation on page load
            window.addEventListener('load', () => {
                document.body.classList.add('page-loaded');
            });
        }
    }));
    
    // Touch Gesture Component
    Alpine.data('touchGesture', (options = {}) => ({
        startX: 0,
        startY: 0,
        currentX: 0,
        currentY: 0,
        threshold: options.threshold || 50,
        
        handleTouchStart(e) {
            this.startX = e.touches[0].clientX;
            this.startY = e.touches[0].clientY;
        },
        
        handleTouchMove(e) {
            this.currentX = e.touches[0].clientX;
            this.currentY = e.touches[0].clientY;
        },
        
        handleTouchEnd() {
            const diffX = this.startX - this.currentX;
            const diffY = this.startY - this.currentY;
            
            // Only trigger if horizontal swipe is more significant than vertical
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > this.threshold) {
                if (diffX > 0) {
                    this.$dispatch('swipe-left');
                } else {
                    this.$dispatch('swipe-right');
                }
            }
            
            // Vertical swipes
            if (Math.abs(diffY) > Math.abs(diffX) && Math.abs(diffY) > this.threshold) {
                if (diffY > 0) {
                    this.$dispatch('swipe-up');
                } else {
                    this.$dispatch('swipe-down');
                }
            }
        },
        
        init() {
            this.$el.addEventListener('touchstart', this.handleTouchStart.bind(this));
            this.$el.addEventListener('touchmove', this.handleTouchMove.bind(this));
            this.$el.addEventListener('touchend', this.handleTouchEnd.bind(this));
        }
    }));
    
    // Smooth Scroll Component
    Alpine.data('smoothScroll', () => ({
        scrollTo(target, options = {}) {
            const element = typeof target === 'string' ? document.querySelector(target) : target;
            if (!element) return;
            
            const offset = options.offset || 0;
            const behavior = options.behavior || 'smooth';
            
            const elementPosition = element.offsetTop - offset;
            
            window.scrollTo({
                top: elementPosition,
                behavior: behavior
            });
        },
        
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    }));
    
    // Intersection Observer Component
    Alpine.data('intersectionObserver', (options = {}) => ({
        isVisible: false,
        hasBeenVisible: false,
        
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    this.isVisible = entry.isIntersecting;
                    if (entry.isIntersecting && !this.hasBeenVisible) {
                        this.hasBeenVisible = true;
                        this.$dispatch('element-visible');
                    }
                });
            }, {
                threshold: options.threshold || 0.1,
                rootMargin: options.rootMargin || '0px'
            });
            
            observer.observe(this.$el);
        }
    }));
    
    // Lazy Loading Component
    Alpine.data('lazyLoad', () => ({
        loaded: false,
        error: false,
        
        loadImage(src) {
            const img = new Image();
            img.onload = () => {
                this.loaded = true;
                this.$el.src = src;
            };
            img.onerror = () => {
                this.error = true;
            };
            img.src = src;
        },
        
        init() {
            const src = this.$el.dataset.src;
            if (!src) return;
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this.loaded && !this.error) {
                        this.loadImage(src);
                        observer.unobserve(this.$el);
                    }
                });
            });
            
            observer.observe(this.$el);
        }
    }));
    
    // Infinite Scroll Component
    Alpine.data('infiniteScroll', (options = {}) => ({
        loading: false,
        hasMore: true,
        page: 1,
        
        async loadMore() {
            if (this.loading || !this.hasMore) return;
            
            this.loading = true;
            
            try {
                const response = await fetch(`${options.endpoint}?page=${this.page + 1}`);
                const data = await response.json();
                
                if (data.data && data.data.length > 0) {
                    this.page++;
                    this.$dispatch('items-loaded', data.data);
                    
                    // Check if there are more pages
                    this.hasMore = data.current_page < data.last_page;
                } else {
                    this.hasMore = false;
                }
            } catch (error) {
                console.error('Error loading more items:', error);
            } finally {
                this.loading = false;
            }
        },
        
        init() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.loadMore();
                    }
                });
            }, {
                threshold: 0.1
            });
            
            observer.observe(this.$el);
        }
    }));
    
    // Clipboard Component
    Alpine.data('clipboard', () => ({
        copied: false,
        
        async copy(text) {
            try {
                if (navigator.clipboard) {
                    await navigator.clipboard.writeText(text);
                } else {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                }
                
                this.copied = true;
                this.$dispatch('text-copied', text);
                
                // Reset after 2 seconds
                setTimeout(() => {
                    this.copied = false;
                }, 2000);
            } catch (error) {
                console.error('Failed to copy text:', error);
            }
        }
    }));
    
    // Auto-save Component
    Alpine.data('autoSave', (options = {}) => ({
        saving: false,
        lastSaved: null,
        isDirty: false,
        
        async save(data) {
            if (this.saving) return;
            
            this.saving = true;
            
            try {
                const response = await fetch(options.endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(data)
                });
                
                if (response.ok) {
                    this.lastSaved = new Date();
                    this.isDirty = false;
                    this.$dispatch('auto-saved');
                }
            } catch (error) {
                console.error('Auto-save failed:', error);
            } finally {
                this.saving = false;
            }
        },
        
        markDirty() {
            this.isDirty = true;
        },
        
        init() {
            // Auto-save every 30 seconds if dirty
            setInterval(() => {
                if (this.isDirty && !this.saving) {
                    const formData = new FormData(this.$el);
                    const data = Object.fromEntries(formData);
                    this.save(data);
                }
            }, options.interval || 30000);
        }
    }));
}

// Global Alpine.js utilities
window.Alpine = window.Alpine || {};
window.Alpine.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

// Global utility functions
window.iOS16Utils = {
    // Show toast notification
    showToast(message, type = 'info', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `ios-toast ios-toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <span class="toast-message">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });
        
        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, duration);
    },
    
    // Haptic feedback for mobile
    hapticFeedback(type = 'light') {
        if ('vibrate' in navigator) {
            switch (type) {
                case 'light':
                    navigator.vibrate(10);
                    break;
                case 'medium':
                    navigator.vibrate(20);
                    break;
                case 'heavy':
                    navigator.vibrate(50);
                    break;
            }
        }
    },
    
    // Format file size
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    
    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // Throttle function
    throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
};
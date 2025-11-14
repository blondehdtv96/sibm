# Home Slider Management System

## Overview
Sistem manajemen slider untuk homepage yang memungkinkan admin mengelola gambar hero slider dengan judul, subtitle, dan call-to-action button.

## Status: ⚠️ IN PROGRESS

Sistem ini sedang dalam tahap implementasi. Berikut adalah checklist progress:

### ✅ Completed
- [x] Database migration created
- [x] Model HomeSlider created

### 🔄 In Progress
- [ ] Admin Controller (CRUD)
- [ ] Admin Views (index, create, edit)
- [ ] Routes registration
- [ ] Homepage integration
- [ ] Swiper.js slider implementation
- [ ] Sample data seeder

### 📋 Pending
- [ ] Image optimization
- [ ] Drag & drop reordering
- [ ] Analytics tracking
- [ ] A/B testing support

## Database Schema

### Table: home_sliders
```sql
- id (bigint, primary key)
- image_path (string) - Path to slider image
- title (string, nullable) - Main heading
- subtitle (text, nullable) - Subheading/description
- button_text (string, nullable) - CTA button text
- button_link (string, nullable) - CTA button URL
- order (integer) - Display order
- status (enum: active, inactive) - Visibility status
- created_at (timestamp)
- updated_at (timestamp)
```

## Features

### Admin Features
1. **CRUD Operations**
   - Create new slider
   - Edit existing slider
   - Delete slider
   - Reorder sliders

2. **Slider Configuration**
   - Upload image (recommended: 1920x1080px)
   - Set title & subtitle
   - Configure CTA button (text & link)
   - Set display order
   - Toggle active/inactive status

3. **Preview**
   - Preview slider before publishing
   - View on homepage

### Frontend Features
1. **Responsive Slider**
   - Full-width hero slider
   - Auto-play with pause on hover
   - Touch/swipe support (mobile)
   - Navigation arrows
   - Pagination dots

2. **Content Overlay**
   - Title with animation
   - Subtitle with animation
   - CTA button with hover effect
   - Gradient overlay for readability

## Implementation Plan

### Phase 1: Backend (Current)
1. ✅ Create migration
2. ✅ Create model
3. ⏳ Create controller
4. ⏳ Create routes
5. ⏳ Create admin views

### Phase 2: Frontend
1. Update HomeController
2. Redesign homepage
3. Integrate Swiper.js
4. Add animations
5. Mobile optimization

### Phase 3: Enhancement
1. Image optimization
2. Lazy loading
3. Analytics
4. A/B testing

## File Structure

```
app/
├── Models/
│   └── HomeSlider.php ✅
├── Http/Controllers/
│   └── Admin/
│       └── HomeSliderController.php ⏳
database/
├── migrations/
│   └── 2025_01_08_120000_create_home_sliders_table.php ✅
└── seeders/
    └── HomeSliderSeeder.php ⏳
resources/
└── views/
    ├── admin/
    │   └── home-sliders/
    │       ├── index.blade.php ⏳
    │       ├── create.blade.php ⏳
    │       └── edit.blade.php ⏳
    └── public/
        └── home.blade.php ⏳ (redesign)
```

## Usage (After Implementation)

### Admin: Manage Sliders
1. Login as admin
2. Navigate to Settings → Home Slider
3. Click "Add Slider"
4. Upload image (1920x1080px recommended)
5. Fill in title, subtitle, button text & link
6. Set order and status
7. Save

### Frontend: Display
Sliders will automatically display on homepage with:
- Auto-play (5 seconds per slide)
- Smooth transitions
- Responsive design
- Touch-friendly controls

## Technical Specifications

### Image Requirements
- **Resolution**: 1920x1080px (16:9 ratio)
- **Format**: JPG, PNG
- **Max Size**: 5MB
- **Optimization**: Recommended before upload

### Slider Settings
- **Auto-play**: 5 seconds
- **Transition**: Fade effect
- **Loop**: Infinite
- **Pause on hover**: Yes
- **Touch/Swipe**: Enabled

### Browser Support
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers

## Next Steps

To continue implementation, run:
```bash
php artisan migrate
```

Then create:
1. HomeSliderController
2. Admin views
3. Routes
4. Homepage redesign
5. Seeder with sample data

## Notes
- This is a minimal viable implementation
- Can be extended with more features later
- Focus on core functionality first
- Performance optimization in phase 3

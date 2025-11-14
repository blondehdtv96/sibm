# 🗺️ SYSTEM OVERVIEW DIAGRAM

**Sistem Manajemen Sekolah SMK Bina Mandiri**  
**Visual Guide & Architecture Diagram**

---

## 📊 SYSTEM ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────────┐
│                    SISTEM MANAJEMEN SEKOLAH                      │
│                        SMK BINA MANDIRI                          │
└─────────────────────────────────────────────────────────────────┘
                                 │
                ┌────────────────┴────────────────┐
                │                                  │
        ┌───────▼────────┐              ┌────────▼────────┐
        │  PUBLIC SIDE   │              │   ADMIN SIDE    │
        │  (Pengunjung)  │              │  (Admin Panel)  │
        └───────┬────────┘              └────────┬────────┘
                │                                  │
    ┌───────────┼──────────────┐      ┌──────────┼──────────────┐
    │           │              │      │          │              │
┌───▼───┐  ┌───▼───┐  ┌──────▼──┐  ┌▼────┐  ┌──▼───┐  ┌──────▼──┐
│ Home  │  │ PPDB  │  │ Content │  │ CMS │  │ PPDB │  │Settings │
│Slider │  │Online │  │ Pages   │  │Mgmt │  │ Mgmt │  │  Mgmt   │
└───┬───┘  └───┬───┘  └────┬────┘  └──┬──┘  └──┬───┘  └────┬────┘
    │          │           │           │        │           │
    └──────────┴───────────┴───────────┴────────┴───────────┘
                            │
                    ┌───────▼────────┐
                    │   LARAVEL APP  │
                    │   (Backend)    │
                    └───────┬────────┘
                            │
                ┌───────────┼───────────┐
                │           │           │
        ┌───────▼───┐  ┌───▼────┐  ┌──▼─────┐
        │Controllers│  │ Models │  │  Views │
        └───────┬───┘  └───┬────┘  └──┬─────┘
                │          │           │
                └──────────┴───────────┘
                            │
                    ┌───────▼────────┐
                    │  MySQL DATABASE│
                    │  (15+ Tables)  │
                    └────────────────┘
```

---

## 🏗️ MODULE ARCHITECTURE

```
┌─────────────────────────────────────────────────────────────┐
│                      MAIN MODULES                            │
└─────────────────────────────────────────────────────────────┘

┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│ HOME SLIDER  │  │  COMPETENCY  │  │     MENU     │
│   SYSTEM     │  │    IMAGES    │  │  MANAGEMENT  │
├──────────────┤  ├──────────────┤  ├──────────────┤
│ • Slider     │  │ • Gallery    │  │ • Dynamic    │
│ • Auto-play  │  │ • Lightbox   │  │ • Submenu    │
│ • CTA Button │  │ • Multiple   │  │ • Order      │
│ • Responsive │  │ • Swiper.js  │  │ • Active     │
└──────────────┘  └──────────────┘  └──────────────┘

┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│   SETTINGS   │  │   CHATBOT    │  │ NOTIFICATION │
│  MANAGEMENT  │  │    SYSTEM    │  │    SYSTEM    │
├──────────────┤  ├──────────────┤  ├──────────────┤
│ • School     │  │ • AI Bot     │  │ • Real-time  │
│ • Contact    │  │ • Keywords   │  │ • Email      │
│ • Logo       │  │ • History    │  │ • Badge      │
│ • Social     │  │ • Widget     │  │ • Mark Read  │
└──────────────┘  └──────────────┘  └──────────────┘

┌──────────────┐  ┌──────────────┐  ┌──────────────┐
│     PPDB     │  │     CMS      │  │    ERROR     │
│    ONLINE    │  │   CONTENT    │  │    PAGES     │
├──────────────┤  ├──────────────┤  ├──────────────┤
│ • Register   │  │ • News       │  │ • 404        │
│ • Track      │  │ • Pages      │  │ • 403        │
│ • Notify     │  │ • Gallery    │  │ • 500        │
│ • Export     │  │ • Category   │  │ • Branded    │
└──────────────┘  └──────────────┘  └──────────────┘
```

---

## 🔄 DATA FLOW DIAGRAM

### Public User Flow
```
┌─────────┐
│ Visitor │
└────┬────┘
     │
     ▼
┌─────────────┐
│  Homepage   │ ◄─── Home Slider System
│  (Slider)   │
└────┬────────┘
     │
     ├──► View Programs ──► Competency Images
     │
     ├──► Read News ──► News Detail
     │
     ├──► View Gallery ──► Photo Albums
     │
     ├──► PPDB Register ──► Form ──► Submit ──► Email
     │
     └──► Chat ──► Chatbot ──► Response
```

### Admin User Flow
```
┌───────┐
│ Admin │
└───┬───┘
    │
    ▼
┌────────┐
│ Login  │
└───┬────┘
    │
    ▼
┌───────────┐
│ Dashboard │ ◄─── Statistics & Charts
└─────┬─────┘
      │
      ├──► Manage Slider ──► CRUD Operations
      │
      ├──► Manage Content ──► News/Pages/Gallery
      │
      ├──► Manage PPDB ──► Review/Approve
      │
      ├──► Manage Settings ──► School/Contact/Logo
      │
      ├──► Manage Chatbot ──► Responses/History
      │
      └──► View Notifications ──► Mark Read
```

---

## 🗄️ DATABASE RELATIONSHIPS

```
┌──────────┐
│  users   │
└────┬─────┘
     │ 1
     │
     │ N
     ├──────► notifications
     │
     │ N
     └──────► ppdb_registrations


┌──────────────┐
│ competencies │
└──────┬───────┘
       │ 1
       │
       │ N
       └──────► competency_images


┌────────┐
│ menus  │ ◄──┐
└───┬────┘    │
    │ 1       │
    │         │ N (self-reference)
    └─────────┘


┌──────────────┐
│ home_sliders │
└──────────────┘
(standalone)


┌──────────┐
│ settings │
└──────────┘
(key-value pairs)


┌────────────────────┐
│ chatbot_responses  │
└────────────────────┘
(standalone)


┌──────────────┐
│ chat_history │
└──────────────┘
(standalone)
```

---

## 📁 FILE STRUCTURE TREE

```
sibm/
│
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── HomeSliderController.php
│   │   │   ├── CompetencyImageController.php
│   │   │   ├── MenuController.php
│   │   │   ├── SettingController.php
│   │   │   ├── ChatbotResponseController.php
│   │   │   └── NotificationController.php
│   │   ├── Public/
│   │   │   ├── HomeController.php
│   │   │   └── CompetencyController.php
│   │   └── ChatbotController.php
│   │
│   ├── Models/
│   │   ├── HomeSlider.php
│   │   ├── CompetencyImage.php
│   │   ├── Menu.php
│   │   ├── Setting.php
│   │   ├── ChatbotResponse.php
│   │   └── ChatHistory.php
│   │
│   └── View/Composers/
│       └── SettingsComposer.php
│
├── database/
│   ├── migrations/
│   │   ├── *_create_settings_table.php
│   │   ├── *_create_home_sliders_table.php
│   │   ├── *_create_competency_images_table.php
│   │   └── *_create_chatbot_responses_table.php
│   │
│   └── seeders/
│       ├── HomeSliderSeeder.php
│       ├── MenuSeeder.php
│       ├── SchoolContentSeeder.php
│       └── ChatbotResponseSeeder.php
│
├── resources/views/
│   ├── admin/
│   │   ├── home-sliders/
│   │   ├── competency-images/
│   │   ├── menus/
│   │   ├── settings/
│   │   ├── chatbot-responses/
│   │   └── notifications/
│   │
│   ├── public/
│   │   ├── home-new.blade.php
│   │   └── competencies/show.blade.php
│   │
│   ├── components/
│   │   ├── chatbot.blade.php
│   │   ├── whatsapp-float.blade.php
│   │   └── page-loader.blade.php
│   │
│   └── errors/
│       ├── 404.blade.php
│       ├── 403.blade.php
│       └── 500.blade.php
│
└── routes/
    └── web.php
```

---

## 🔌 API ENDPOINTS MAP

```
PUBLIC ROUTES
├── GET  /                          → Homepage with slider
├── GET  /competencies              → List programs
├── GET  /competencies/{slug}       → Program detail
├── GET  /news                      → List news
├── GET  /news/{slug}               → News detail
├── GET  /ppdb/register             → PPDB form
├── POST /ppdb/register             → Submit PPDB
├── GET  /ppdb/check-status         → Check status form
├── POST /ppdb/check-status         → Get status
└── POST /chatbot/send              → Send message

ADMIN ROUTES (Protected)
├── GET  /admin/dashboard           → Dashboard
├── /admin/home-sliders
│   ├── GET    /                    → List sliders
│   ├── GET    /create              → Create form
│   ├── POST   /                    → Store slider
│   ├── GET    /{id}/edit           → Edit form
│   ├── PUT    /{id}                → Update slider
│   └── DELETE /{id}                → Delete slider
├── /admin/competency-images
│   ├── GET    /                    → List images
│   ├── POST   /                    → Upload image
│   └── DELETE /{id}                → Delete image
├── /admin/menus
│   ├── GET    /                    → List menus
│   ├── POST   /                    → Create menu
│   ├── PUT    /{id}                → Update menu
│   └── DELETE /{id}                → Delete menu
├── /admin/settings
│   ├── GET    /                    → School content
│   ├── POST   /update              → Update settings
│   ├── GET    /contact-social      → Contact settings
│   └── POST   /logo                → Upload logo
├── /admin/chatbot-responses
│   ├── GET    /                    → List responses
│   ├── POST   /                    → Create response
│   └── GET    /history             → Chat history
└── /admin/notifications
    ├── GET    /                    → List notifications
    ├── POST   /{id}/read           → Mark as read
    └── POST   /read-all            → Mark all read
```

---

## 🎨 UI COMPONENT HIERARCHY

```
┌─────────────────────────────────────────┐
│         PUBLIC LAYOUT                    │
│  (public-tailwind.blade.php)            │
├─────────────────────────────────────────┤
│                                          │
│  ┌────────────────────────────────┐    │
│  │         NAVBAR                  │    │
│  │  (Logo, Menu, Search)          │    │
│  └────────────────────────────────┘    │
│                                          │
│  ┌────────────────────────────────┐    │
│  │      HERO SLIDER               │    │
│  │  (Swiper.js, Auto-play)       │    │
│  └────────────────────────────────┘    │
│                                          │
│  ┌────────────────────────────────┐    │
│  │      CONTENT SECTIONS          │    │
│  │  • Programs                    │    │
│  │  • News                        │    │
│  │  • Gallery                     │    │
│  │  • Testimonials                │    │
│  └────────────────────────────────┘    │
│                                          │
│  ┌────────────────────────────────┐    │
│  │         FOOTER                  │    │
│  │  (Contact, Social, Links)      │    │
│  └────────────────────────────────┘    │
│                                          │
│  ┌────────────────────────────────┐    │
│  │    FLOATING COMPONENTS         │    │
│  │  • Chatbot Widget              │    │
│  │  • WhatsApp Button             │    │
│  └────────────────────────────────┘    │
│                                          │
└─────────────────────────────────────────┘


┌─────────────────────────────────────────┐
│         ADMIN LAYOUT                     │
│  (admin-modern.blade.php)               │
├─────────────────────────────────────────┤
│                                          │
│  ┌──────┐  ┌──────────────────────┐    │
│  │      │  │     TOP BAR           │    │
│  │      │  │  (User, Notifications)│    │
│  │      │  └──────────────────────┘    │
│  │ SIDE │                               │
│  │ BAR  │  ┌──────────────────────┐    │
│  │      │  │                       │    │
│  │ Menu │  │    MAIN CONTENT       │    │
│  │Items │  │                       │    │
│  │      │  │  • Dashboard          │    │
│  │      │  │  • CRUD Forms         │    │
│  │      │  │  • Data Tables        │    │
│  │      │  │  • Charts             │    │
│  │      │  │                       │    │
│  └──────┘  └──────────────────────┘    │
│                                          │
└─────────────────────────────────────────┘
```

---

## 🔐 SECURITY LAYERS

```
┌─────────────────────────────────────────┐
│          SECURITY LAYERS                 │
└─────────────────────────────────────────┘

Layer 1: Authentication
├── Login System
├── Session Management
├── Password Hashing (bcrypt)
└── Remember Me Token

Layer 2: Authorization
├── Role-based Access Control
├── Middleware Protection
├── Route Guards
└── Permission Checks

Layer 3: Input Validation
├── Form Validation
├── CSRF Protection
├── XSS Prevention
└── SQL Injection Prevention

Layer 4: File Security
├── File Type Validation
├── File Size Limits
├── Secure Storage
└── Access Control

Layer 5: Data Security
├── Encrypted Passwords
├── Secure Sessions
├── HTTPS (Production)
└── Database Security
```

---

## 📊 PERFORMANCE OPTIMIZATION

```
┌─────────────────────────────────────────┐
│      PERFORMANCE STRATEGIES              │
└─────────────────────────────────────────┘

Frontend Optimization
├── Asset Minification (CSS/JS)
├── Image Optimization
├── Lazy Loading
├── CDN for Libraries
└── Browser Caching

Backend Optimization
├── Query Optimization
├── Eager Loading
├── Database Indexing
├── Route Caching
└── Config Caching

Caching Strategy
├── View Cache
├── Route Cache
├── Config Cache
├── Query Cache
└── OPcache (PHP)

Database Optimization
├── Proper Indexing
├── N+1 Query Prevention
├── Connection Pooling
└── Query Monitoring
```

---

## 🔄 DEPLOYMENT WORKFLOW

```
┌─────────────────────────────────────────┐
│       DEPLOYMENT PROCESS                 │
└─────────────────────────────────────────┘

Development
    │
    ├─► Code & Test
    │
    ├─► Git Commit
    │
    └─► Push to Repository
         │
         ▼
Staging
    │
    ├─► Pull Code
    │
    ├─► Run Migrations
    │
    ├─► Run Tests
    │
    └─► QA Testing
         │
         ▼
Production
    │
    ├─► Backup Database
    │
    ├─► Pull Code
    │
    ├─► Run Migrations
    │
    ├─► Clear Caches
    │
    ├─► Optimize
    │
    └─► Monitor
```

---

## 📱 RESPONSIVE DESIGN BREAKPOINTS

```
┌─────────────────────────────────────────┐
│        RESPONSIVE BREAKPOINTS            │
└─────────────────────────────────────────┘

Mobile (< 768px)
├── Single column layout
├── Stacked navigation
├── Touch-optimized
├── Swipe gestures
└── Larger tap targets

Tablet (768px - 1199px)
├── Two column layout
├── Collapsible sidebar
├── Touch & mouse support
├── Optimized spacing
└── Responsive images

Desktop (1200px+)
├── Multi-column layout
├── Full sidebar
├── Hover effects
├── Keyboard shortcuts
└── Full features
```

---

## 🎯 USER JOURNEY MAP

### Visitor Journey
```
Landing → Browse → Interested → Action
   │        │          │          │
   │        │          │          ├─► Register PPDB
   │        │          │          ├─► Contact
   │        │          │          └─► Chat
   │        │          │
   │        │          └─► View Details
   │        │
   │        ├─► Programs
   │        ├─► News
   │        └─► Gallery
   │
   └─► Homepage Slider
```

### Admin Journey
```
Login → Dashboard → Manage → Save → Publish
  │        │          │        │       │
  │        │          │        │       └─► Live on Site
  │        │          │        │
  │        │          │        └─► Validate & Save
  │        │          │
  │        │          ├─► Content (News/Pages)
  │        │          ├─► Slider
  │        │          ├─► PPDB
  │        │          └─► Settings
  │        │
  │        └─► View Statistics
  │
  └─► Authentication
```

---

## 🎨 COLOR SCHEME & BRANDING

```
┌─────────────────────────────────────────┐
│          DESIGN SYSTEM                   │
└─────────────────────────────────────────┘

Primary Colors
├── Blue: #3B82F6 (Primary actions)
├── Green: #10B981 (Success states)
├── Red: #EF4444 (Errors/Delete)
└── Yellow: #F59E0B (Warnings)

Neutral Colors
├── Gray-50: #F9FAFB (Backgrounds)
├── Gray-200: #E5E7EB (Borders)
├── Gray-600: #4B5563 (Text secondary)
└── Gray-900: #111827 (Text primary)

Typography
├── Headings: Inter/System Sans
├── Body: Inter/System Sans
├── Code: Monospace
└── Sizes: 12px - 48px

Spacing
├── Base: 4px
├── Scale: 4, 8, 12, 16, 24, 32, 48, 64
└── Container: 1200px max-width
```

---

## 📈 ANALYTICS & MONITORING

```
┌─────────────────────────────────────────┐
│      MONITORING DASHBOARD                │
└─────────────────────────────────────────┘

System Health
├── Server Status
├── Database Status
├── Storage Usage
└── Error Logs

User Metrics
├── Total Visitors
├── Page Views
├── Bounce Rate
└── Session Duration

Content Metrics
├── Popular Pages
├── Popular Programs
├── News Views
└── Gallery Views

PPDB Metrics
├── Total Registrations
├── Pending Reviews
├── Approved
└── Conversion Rate

Performance
├── Page Load Time
├── Database Queries
├── API Response Time
└── Error Rate
```

---

## 🔧 MAINTENANCE SCHEDULE

```
┌─────────────────────────────────────────┐
│      MAINTENANCE CALENDAR                │
└─────────────────────────────────────────┘

Daily
├── 08:00 - Check notifications
├── 10:00 - Review PPDB registrations
├── 14:00 - Update content
└── 16:00 - Monitor logs

Weekly
├── Monday - Backup database
├── Wednesday - Update content
├── Friday - Review analytics
└── Sunday - System check

Monthly
├── Week 1 - Security audit
├── Week 2 - Performance review
├── Week 3 - Update dependencies
└── Week 4 - Clean old data

Quarterly
├── Major updates
├── Feature additions
├── User feedback review
└── System optimization
```

---

**Diagram ini memberikan visual overview lengkap dari sistem!** 🎨

Gunakan diagram ini sebagai referensi cepat untuk memahami struktur dan alur sistem.

---

**Last Updated**: 14 November 2025  
**Version**: 1.0.0  
**Created by**: Kiro AI Assistant

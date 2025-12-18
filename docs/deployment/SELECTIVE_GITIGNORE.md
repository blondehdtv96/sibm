# Selective GitIgnore Configuration

## Overview
Konfigurasi .gitignore yang selektif untuk mengabaikan file log dan temporary files, tapi tetap mengupload struktur folder dan file penting ke GitHub.

## Strategy
- ✅ **Upload**: Struktur folder, file konfigurasi, source code
- ❌ **Ignore**: Log files, cache files, temporary files, dependencies

## Files Ignored

### 1. Environment & Security Files ❌
```
.env
.env.backup
.env.production
```
**Reason**: Contains sensitive data (database passwords, API keys)

### 2. Dependencies ❌
```
/vendor/
/node_modules/
```
**Reason**: Large files, can be regenerated with `composer install` and `npm install`

### 3. Log Files Only ❌
```
storage/logs/*.log
storage/logs/laravel*.log
```
**Reason**: Log files can be large and contain sensitive information
**Folder**: `storage/logs/` folder structure is maintained

### 4. Cache Files Only ❌
```
storage/framework/cache/data/*
storage/framework/sessions/*
storage/framework/views/*
storage/framework/testing/*
bootstrap/cache/*
```
**Reason**: Temporary files, regenerated automatically
**Folders**: All folder structures are maintained

### 5. Compiled Assets ❌
```
/public/hot
/public/storage
/public/css/app.css
/public/js/app.js
/public/mix-manifest.json
```
**Reason**: Generated files, can be rebuilt

### 6. IDE & OS Files ❌
```
.vscode/
.idea/
.DS_Store
Thumbs.db
```
**Reason**: Development environment specific

## Files Uploaded ✅

### 1. Source Code ✅
- All PHP files (`app/`, `config/`, `database/`, `routes/`)
- All Blade templates (`resources/views/`)
- All assets (`resources/css/`, `resources/js/`)

### 2. Configuration Files ✅
- `composer.json` & `composer.lock`
- `package.json` & `package-lock.json`
- `artisan`
- All config files

### 3. Database Files ✅
- Migrations (`database/migrations/`)
- Seeders (`database/seeders/`)
- Factories (`database/factories/`)

### 4. Public Assets ✅
- Images (`public/images/`)
- Static files (`public/css/`, `public/js/`)
- `robots.txt`, `favicon.ico`

### 5. Documentation ✅
- `README.md`
- All documentation (`docs/`)

### 6. Folder Structure ✅
All important folders are maintained:
```
storage/
├── app/           ✅ (uploaded)
├── framework/     ✅ (structure maintained)
│   ├── cache/     ✅ (structure maintained)
│   ├── sessions/  ✅ (structure maintained)
│   ├── testing/   ✅ (structure maintained)
│   └── views/     ✅ (structure maintained)
└── logs/          ✅ (structure maintained)
```

## GitIgnore Files Created

### 1. Root .gitignore
**File**: `.gitignore`
- Main ignore rules
- Environment files
- Dependencies
- IDE files

### 2. Storage Logs .gitignore
**File**: `storage/logs/.gitignore`
```
*.log
laravel*.log
!.gitignore
```

### 3. Cache Data .gitignore
**File**: `storage/framework/cache/data/.gitignore`
```
*
!.gitignore
```

### 4. Sessions .gitignore
**File**: `storage/framework/sessions/.gitignore`
```
*
!.gitignore
```

### 5. Views .gitignore
**File**: `storage/framework/views/.gitignore`
```
*
!.gitignore
```

### 6. Testing .gitignore
**File**: `storage/framework/testing/.gitignore`
```
*
!.gitignore
```

### 7. Bootstrap Cache .gitignore
**File**: `bootstrap/cache/.gitignore`
```
*
!.gitignore
```

## Benefits

### 1. Clean Repository ✅
- No log files cluttering the repo
- No temporary files
- Only essential code uploaded

### 2. Security ✅
- Environment files protected
- No sensitive logs uploaded
- API keys and passwords safe

### 3. Performance ✅
- Smaller repository size
- Faster clone/download
- No unnecessary files

### 4. Maintainability ✅
- Folder structure preserved
- Easy deployment
- Clear separation of concerns

## Deployment Process

### 1. Clone Repository
```bash
git clone https://github.com/username/repository.git
cd repository
```

### 2. Install Dependencies
```bash
composer install --no-dev --optimize-autoloader
npm install --production
```

### 3. Setup Environment
```bash
cp .env.example .env
# Edit .env with production values
php artisan key:generate
```

### 4. Setup Storage
```bash
php artisan storage:link
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### 5. Build Assets (if needed)
```bash
npm run production
```

### 6. Setup Database
```bash
php artisan migrate --force
php artisan db:seed --force
```

## What Gets Uploaded vs Ignored

### ✅ Uploaded to GitHub:
```
app/                    ← Source code
config/                 ← Configuration
database/               ← Migrations, seeders
resources/              ← Views, assets
routes/                 ← Route definitions
public/images/          ← Static images
storage/app/            ← User uploads
docs/                   ← Documentation
composer.json           ← Dependencies list
package.json            ← Node dependencies
artisan                 ← Laravel CLI
README.md               ← Project info
```

### ❌ Ignored (Not Uploaded):
```
.env                    ← Environment variables
vendor/                 ← PHP dependencies
node_modules/           ← Node dependencies
storage/logs/*.log      ← Log files
storage/framework/cache/ ← Cache files
storage/framework/sessions/ ← Session files
bootstrap/cache/        ← Bootstrap cache
.vscode/                ← IDE settings
.DS_Store               ← OS files
```

## Testing

### 1. Check What Will Be Uploaded
```bash
git status
git add .
git status
```

### 2. Verify Ignored Files
```bash
git check-ignore storage/logs/laravel.log
git check-ignore .env
git check-ignore vendor/
```

### 3. Test Clone
```bash
git clone <your-repo> test-clone
cd test-clone
# Check if folder structure exists
ls -la storage/
ls -la storage/framework/
```

## Status
✅ CONFIGURED - Selective .gitignore created for optimal GitHub upload

---

**Date**: December 18, 2025  
**Action**: Create selective .gitignore configuration  
**Result**: Only essential files uploaded, logs and cache ignored  
**Status**: Ready for production deployment
# Setup Instructions for Laravel School Management System

## Prerequisites

Before you begin, ensure you have the following installed on your system:

### Required Software
- **PHP 8.1 or higher** with the following extensions:
  - BCMath PHP Extension
  - Ctype PHP Extension
  - cURL PHP Extension
  - DOM PHP Extension
  - Fileinfo PHP Extension
  - JSON PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PCRE PHP Extension
  - PDO PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension
  - GD PHP Extension (for image processing)

- **Composer** (PHP dependency manager)
- **MySQL 8.0 or higher**
- **Node.js 16+ and npm** (for asset compilation)
- **Git** (for version control)

### Installing PHP 8.1+ on Different Systems

#### Windows
1. Download PHP 8.1+ from https://windows.php.net/download/
2. Extract to a folder (e.g., C:\php)
3. Add PHP to your system PATH
4. Copy php.ini-development to php.ini and configure as needed

#### macOS (using Homebrew)
```bash
brew install php@8.1
brew link php@8.1 --force
```

#### Ubuntu/Debian
```bash
sudo apt update
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.1 php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath
```

### Installing Composer
```bash
# Download and install Composer globally
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

## Step-by-Step Setup

### 1. Project Setup
Since you currently have PHP 7.0, you'll need to upgrade first. Once you have PHP 8.1+:

```bash
# Create a new Laravel project
composer create-project laravel/laravel laravel-school-management

# Or if you have the project files already:
cd laravel-school-management
composer install
```

### 2. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup
Create a MySQL database and update your `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_school_management
DB_USERNAME=your_mysql_username
DB_PASSWORD=your_mysql_password
```

### 4. Install Additional Dependencies
```bash
# Install Laravel Sanctum for authentication
composer require laravel/sanctum

# Install image processing library
composer require intervention/image

# Install permissions package
composer require spatie/laravel-permission

# Install development dependencies
composer require --dev laravel/dusk
```

### 5. Publish Sanctum Configuration
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 6. Frontend Dependencies
```bash
# Install Node.js dependencies
npm install

# Install additional packages for iOS 16 styling
npm install alpinejs @tailwindcss/forms
```

### 7. Database Migration and Seeding
```bash
# Run migrations
php artisan migrate

# Run seeders (after creating them in later tasks)
php artisan db:seed
```

### 8. Storage Setup
```bash
# Create storage symlink
php artisan storage:link

# Set proper permissions (Linux/macOS)
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 9. Asset Compilation
```bash
# For development
npm run dev

# For production
npm run build
```

### 10. Start Development Server
```bash
php artisan serve
```

Your application will be available at http://localhost:8000

## Troubleshooting

### Common Issues

1. **Composer memory limit error**
   ```bash
   php -d memory_limit=-1 /usr/local/bin/composer install
   ```

2. **Permission denied errors**
   ```bash
   sudo chown -R $USER:www-data storage
   sudo chown -R $USER:www-data bootstrap/cache
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

3. **MySQL connection refused**
   - Ensure MySQL service is running
   - Check database credentials in `.env`
   - Verify MySQL port (default 3306)

4. **PHP extension missing**
   ```bash
   # Ubuntu/Debian example
   sudo apt install php8.1-gd php8.1-mbstring php8.1-xml
   ```

### Verification Commands

Check your setup with these commands:

```bash
# Check PHP version
php --version

# Check Composer
composer --version

# Check Laravel installation
php artisan --version

# Test database connection
php artisan migrate:status

# Check file permissions
ls -la storage/
```

## Next Steps

After completing the setup:

1. Review the project structure
2. Configure school-specific settings in `config/school.php`
3. Begin implementing the database migrations (Task 2)
4. Set up the authentication system (Task 3)
5. Create the iOS 16 design system (Task 4)

## Production Deployment Notes

For production deployment:

1. Use a proper web server (Apache/Nginx)
2. Configure SSL certificates
3. Set `APP_ENV=production` and `APP_DEBUG=false`
4. Use proper database credentials
5. Configure file permissions securely
6. Set up regular backups
7. Configure caching (Redis/Memcached)
8. Enable OPcache for PHP

## Getting Help

If you encounter issues:
1. Check Laravel documentation: https://laravel.com/docs
2. Review error logs in `storage/logs/`
3. Ensure all requirements are met
4. Verify file permissions and ownership
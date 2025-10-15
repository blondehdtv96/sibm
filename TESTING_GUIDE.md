# Testing Guide

## Quick Start

### Running Database Seeders

```bash
# Fresh migration with all seeders
php artisan migrate:fresh --seed

# Run seeders only (without migration)
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=NewsSeeder
php artisan db:seed --class=PageSeeder
```

### Default Admin Login

After seeding, use these credentials to log in:
- **Email**: admin@school.com
- **Password**: password

### Running Tests

```bash
# Run all tests
php artisan test

# Run with detailed output
php artisan test --verbose

# Run specific test suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run specific test file
php artisan test tests/Unit/UserModelTest.php
php artisan test tests/Feature/AuthenticationTest.php

# Run tests with coverage (requires Xdebug)
php artisan test --coverage

# Run tests in parallel (faster)
php artisan test --parallel
```

## Test Structure

### Unit Tests (tests/Unit/)
- **UserModelTest.php** - User model, roles, relationships
- **PageModelTest.php** - Page model, slugs, status
- **NewsModelTest.php** - News model, categories, publishing
- **CompetencyModelTest.php** - Competency model, ordering
- **GalleryModelTest.php** - Gallery albums and items
- **PpdbModelTest.php** - PPDB registrations and settings

### Feature Tests (tests/Feature/)
- **AuthenticationTest.php** - Login, logout, registration
- **DashboardTest.php** - Role-based dashboard access
- **UserManagementTest.php** - User CRUD operations
- **PageManagementTest.php** - Page CRUD operations
- **NewsManagementTest.php** - News CRUD operations
- **CompetencyManagementTest.php** - Competency CRUD
- **GalleryManagementTest.php** - Gallery management
- **PpdbManagementTest.php** - PPDB registration flow
- **PublicPageTest.php** - Public page viewing
- **PublicNewsTest.php** - Public news viewing
- **SecurityTest.php** - Security measures

## Sample Data Generated

### Users
- 1 Admin (admin@school.com)
- 5 Teachers
- 10 Students

### Content
- 8 Pages (3 essential + 5 sample)
- 5 News Categories
- 23 News Articles (18 published + 5 draft)
- 7 Competency Programs
- 7 Gallery Albums with 40+ items
- 1 Active PPDB Setting
- 17 PPDB Registrations

## Database Factories

All models have factories for easy test data generation:

```php
// Create users
User::factory()->admin()->create();
User::factory()->teacher()->count(5)->create();
User::factory()->student()->count(10)->create();

// Create pages
Page::factory()->published()->create();
Page::factory()->draft()->count(3)->create();

// Create news
News::factory()->published()->count(10)->create();
News::factory()->draft()->create();

// Create competencies
Competency::factory()->active()->count(5)->create();

// Create gallery
$album = GalleryAlbum::factory()->create();
GalleryItem::factory()->count(10)->create(['album_id' => $album->id]);

// Create PPDB registrations
PpdbRegistration::factory()->pending()->count(5)->create();
PpdbRegistration::factory()->verified()->create();
```

## Testing Best Practices

1. **Use RefreshDatabase trait** - Ensures clean database for each test
2. **Use factories** - Generate test data consistently
3. **Test one thing** - Each test should verify one behavior
4. **Use descriptive names** - Test names should describe what they test
5. **Arrange-Act-Assert** - Structure tests clearly

## Continuous Integration

For CI/CD pipelines, use:

```bash
# Run tests with coverage and output for CI
php artisan test --coverage --min=80 --ci
```

## Troubleshooting

### Tests failing with database errors
```bash
# Ensure test database is configured
php artisan config:clear
php artisan cache:clear
```

### Seeder errors
```bash
# Check if migrations are up to date
php artisan migrate:status

# Reset and reseed
php artisan migrate:fresh --seed
```

### Factory errors
```bash
# Clear compiled files
php artisan clear-compiled
composer dump-autoload
```

## Additional Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Database Testing](https://laravel.com/docs/database-testing)

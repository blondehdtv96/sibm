# Security Implementation Guide

## Overview

This document describes the security measures implemented in the Laravel School Management System to protect against common web vulnerabilities and ensure data integrity.

## Table of Contents

1. [CSRF Protection](#csrf-protection)
2. [XSS Protection](#xss-protection)
3. [SQL Injection Prevention](#sql-injection-prevention)
4. [Secure File Upload](#secure-file-upload)
5. [Audit Logging](#audit-logging)
6. [Security Monitoring](#security-monitoring)
7. [Session Security](#session-security)
8. [Configuration](#configuration)

## CSRF Protection

### Implementation
- All forms include `@csrf` directive
- Laravel's `VerifyCsrfToken` middleware validates tokens
- AJAX requests include CSRF token in headers

### Usage
```blade
<form method="POST" action="/submit">
    @csrf
    <!-- form fields -->
</form>
```

For AJAX:
```javascript
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
```

## XSS Protection

### HTML Purification Service

The `HtmlPurifierService` sanitizes user-generated HTML content:

**Features:**
- Removes dangerous tags (script, iframe, object, embed)
- Strips event handlers (onclick, onerror, etc.)
- Validates URLs to prevent javascript: and data: schemes
- Whitelist-based approach for allowed tags and attributes

**Usage:**
```php
use App\Services\HtmlPurifierService;

$purifier = app(HtmlPurifierService::class);

// Purify HTML content
$cleanHtml = $purifier->purify($userHtml);

// Sanitize plain text
$cleanText = $purifier->sanitizeText($userInput);

// Sanitize filename
$cleanFilename = $purifier->sanitizeFilename($filename);
```

### Input Sanitization Middleware

The `SanitizeInput` middleware automatically:
- Removes null bytes from all input
- Trims whitespace
- Applied to all web requests

## SQL Injection Prevention

### Eloquent ORM
- All database queries use Eloquent ORM or Query Builder
- Parameterized queries prevent SQL injection
- Never use raw SQL with user input

**Safe:**
```php
User::where('email', $email)->first();
DB::table('users')->where('email', $email)->get();
```

**Unsafe (Never do this):**
```php
DB::select("SELECT * FROM users WHERE email = '$email'");
```

## Secure File Upload

### SecureFileUpload Validation Rule

Custom validation rule that:
- Validates MIME types
- Checks file extensions
- Detects double extensions (file.php.jpg)
- Validates image files using getimagesize()
- Scans for PHP code in files
- Blocks executable files

**Usage:**
```php
use App\Rules\SecureFileUpload;

'image' => [
    'required',
    new SecureFileUpload(
        allowedMimeTypes: ['image/jpeg', 'image/png'],
        maxSize: 2048,
        allowedExtensions: ['jpg', 'jpeg', 'png']
    )
]
```

### Secure File Storage Service

The `SecureFileStorageService` provides:
- Secure filename generation (random + timestamp)
- File storage outside web root
- Image optimization and resizing
- Thumbnail generation
- Virus scanning framework
- Private document storage

**Usage:**
```php
use App\Services\SecureFileStorageService;

$storage = app(SecureFileStorageService::class);

// Store image with thumbnails
$paths = $storage->storeImage(
    $file,
    'pages',
    ['thumbnail' => [150, 150], 'medium' => [600, 600]]
);

// Store private document
$path = $storage->storeDocument($file, 'ppdb');

// Delete file
$storage->delete($path, 'secure');
```

### File Storage Configuration

Files are stored in:
- `storage/app/public/uploads` - Public images and media
- `storage/app/secure` - Private documents
- `storage/app/ppdb/documents` - PPDB registration documents

All storage directories are outside the web root for security.

## Audit Logging

### Audit Log Service

Comprehensive logging of:
- User authentication (login, logout, failures)
- Model CRUD operations
- File operations
- Permission changes
- Security events

**Usage:**
```php
use App\Services\AuditLogService;

$auditLog = app(AuditLogService::class);

// Log model creation
$auditLog->logCreated($model);

// Log model update
$auditLog->logUpdated($model, $oldValues);

// Log security event
$auditLog->logSecurityEvent('suspicious_activity', $details);
```

### Auditable Trait

Add automatic auditing to any model:

```php
use App\Traits\Auditable;

class Page extends Model
{
    use Auditable;
}
```

This automatically logs created, updated, and deleted events.

### Viewing Audit Logs

```php
// Get recent logs
$logs = $auditLog->getRecentLogs(50);

// Get user's activity
$logs = $auditLog->getUserLogs($userId);

// Get model history
$logs = $auditLog->getModelLogs($model);

// Get security logs
$logs = $auditLog->getSecurityLogs(7); // Last 7 days
```

### Cleaning Old Logs

```bash
php artisan audit:clean --days=90
```

Schedule in `app/Console/Kernel.php`:
```php
$schedule->command('audit:clean --days=90')->monthly();
```

## Security Monitoring

### SecurityMonitoring Middleware

Real-time detection of:
- SQL injection attempts
- XSS attempts
- Path traversal attempts
- Suspicious patterns

**Automatic Actions:**
- Logs to audit log
- Logs to Laravel log
- Can trigger alerts (email, Slack, etc.)
- Can block IPs after multiple attempts

**Detected Patterns:**
- SQL: `UNION SELECT`, `DROP TABLE`, `' OR 1=1`
- XSS: `<script>`, `javascript:`, event handlers
- Path Traversal: `../`, `..\\`, encoded variants

## Session Security

### Configuration

In `config/security.php`:
```php
'session' => [
    'timeout_minutes' => 120,
    'regenerate_on_login' => true,
    'strict_mode' => true,
],
```

### Session Timeout Middleware

The `SessionTimeout` middleware:
- Tracks last activity
- Logs out inactive users
- Regenerates session ID on login

## Configuration

### Environment Variables

Add to `.env`:
```env
# Security Settings
MAX_FILE_SIZE=2048
VIRUS_SCAN_ENABLED=false
CSP_ENABLED=true
SESSION_TIMEOUT=120
AUDIT_ENABLED=true
```

### Security Config

Edit `config/security.php` for:
- File upload settings
- Blocked file extensions
- Image optimization settings
- Content Security Policy
- Rate limiting
- Password policy

## Best Practices

### For Developers

1. **Always validate user input**
   ```php
   $request->validate([
       'email' => 'required|email',
       'name' => 'required|string|max:255',
   ]);
   ```

2. **Use Form Requests for complex validation**
   ```php
   public function store(StorePageRequest $request)
   {
       $validated = $request->validated();
   }
   ```

3. **Sanitize HTML content**
   ```php
   $purifier = app(HtmlPurifierService::class);
   $cleanHtml = $purifier->purify($request->input('content'));
   ```

4. **Use secure file storage**
   ```php
   $storage = app(SecureFileStorageService::class);
   $path = $storage->store($file, 'directory', 'disk', true);
   ```

5. **Log sensitive operations**
   ```php
   $auditLog->logSecurityEvent('password_reset', ['user_id' => $user->id]);
   ```

6. **Never trust user input**
   - Always validate
   - Always sanitize
   - Always escape output

7. **Use HTTPS in production**
   - Set `APP_URL=https://yourdomain.com`
   - Force HTTPS in middleware

8. **Keep dependencies updated**
   ```bash
   composer update
   npm update
   ```

### For Administrators

1. **Regular security audits**
   - Review audit logs weekly
   - Check for suspicious patterns
   - Monitor failed login attempts

2. **Keep software updated**
   - Update Laravel regularly
   - Update PHP version
   - Update server software

3. **Configure backups**
   - Database backups daily
   - File backups weekly
   - Test restore procedures

4. **Monitor logs**
   - Check `storage/logs/laravel.log`
   - Review audit logs
   - Set up log alerts

5. **Use strong passwords**
   - Minimum 8 characters
   - Mix of uppercase, lowercase, numbers
   - Change regularly

## Security Checklist

- [x] CSRF protection on all forms
- [x] XSS protection through HTML purification
- [x] SQL injection prevention (Eloquent ORM)
- [x] Secure file upload validation
- [x] File storage outside web root
- [x] Image optimization and sanitization
- [x] Audit logging for sensitive operations
- [x] Security threat detection
- [x] Input sanitization middleware
- [x] Session security configuration
- [x] Query performance monitoring
- [ ] Virus scanning (framework ready)
- [ ] IP blocking (framework ready)
- [ ] Email alerts (framework ready)
- [ ] HTTPS enforcement (production)
- [ ] Content Security Policy headers
- [ ] Rate limiting configuration

## Incident Response

### If Security Breach Detected

1. **Immediate Actions**
   - Review audit logs
   - Identify affected systems
   - Block suspicious IPs
   - Reset compromised passwords

2. **Investigation**
   - Check security logs
   - Review recent changes
   - Identify vulnerability
   - Document findings

3. **Remediation**
   - Patch vulnerability
   - Update security measures
   - Notify affected users
   - Update documentation

4. **Prevention**
   - Implement additional controls
   - Update security policies
   - Train staff
   - Schedule security audit

## Support

For security issues or questions:
- Review this documentation
- Check Laravel security documentation
- Consult with security team
- Report vulnerabilities responsibly

## Updates

This security implementation is current as of January 2024. Regular updates and security patches should be applied as they become available.

# HTTPS Configuration Guide

## Overview
Panduan lengkap untuk mengkonfigurasi aplikasi agar menggunakan HTTPS (SSL/TLS) untuk keamanan dan SEO yang lebih baik.

## Changes Implemented

### 1. Environment Configuration
**File**: `.env`

```env
# Before
APP_URL=http://localhost

# After
APP_URL=https://www.smkbinamandiribekasi.sch.id
```

### 2. Force HTTPS Middleware
**File**: `app/Http/Middleware/ForceHttps.php`

```php
public function handle(Request $request, Closure $next): Response
{
    // Force HTTPS in production
    if (!$request->secure() && app()->environment('production')) {
        return redirect()->secure($request->getRequestUri(), 301);
    }

    return $next($request);
}
```

### 3. Kernel Registration
**File**: `app/Http/Kernel.php`

```php
protected $middleware = [
    // ... other middleware
    \App\Http\Middleware\ForceHttps::class,
];
```

### 4. URL Force Scheme
**File**: `app/Providers/AppServiceProvider.php`

```php
public function boot(): void
{
    // Force HTTPS in production
    if (app()->environment('production')) {
        \URL::forceScheme('https');
    }
}
```

### 5. .htaccess Redirect
**File**: `public/.htaccess`

```apache
# Force HTTPS
RewriteCond %{HTTPS} off
RewriteCond %{HTTP:X-Forwarded-Proto} !https
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
```

## How It Works

### Request Flow
```
1. User visits: http://www.smkbinamandiribekasi.sch.id
2. .htaccess redirects to: https://www.smkbinamandiribekasi.sch.id
3. ForceHttps middleware checks if HTTPS
4. URL::forceScheme ensures all generated URLs use HTTPS
5. Response sent with HTTPS
```

### Multiple Layers of Protection
1. **.htaccess**: Server-level redirect (Apache)
2. **Middleware**: Application-level redirect (Laravel)
3. **URL Generation**: All route(), url(), asset() use HTTPS

## SSL Certificate Setup

### Option 1: Let's Encrypt (FREE)
```bash
# Install Certbot
sudo apt-get update
sudo apt-get install certbot python3-certbot-apache

# Get certificate
sudo certbot --apache -d www.smkbinamandiribekasi.sch.id -d smkbinamandiribekasi.sch.id

# Auto-renewal
sudo certbot renew --dry-run
```

### Option 2: Commercial SSL
1. Purchase SSL from provider (Comodo, DigiCert, etc.)
2. Generate CSR
3. Install certificate on server
4. Configure Apache/Nginx

### Option 3: Cloudflare (FREE)
1. Add domain to Cloudflare
2. Update nameservers
3. Enable SSL/TLS (Full or Full Strict)
4. Enable "Always Use HTTPS"

## Apache Configuration

### Enable SSL Module
```bash
sudo a2enmod ssl
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Virtual Host Configuration
**File**: `/etc/apache2/sites-available/smkbinamandiribekasi.conf`

```apache
<VirtualHost *:80>
    ServerName www.smkbinamandiribekasi.sch.id
    ServerAlias smkbinamandiribekasi.sch.id
    
    # Redirect to HTTPS
    Redirect permanent / https://www.smkbinamandiribekasi.sch.id/
</VirtualHost>

<VirtualHost *:443>
    ServerName www.smkbinamandiribekasi.sch.id
    ServerAlias smkbinamandiribekasi.sch.id
    
    DocumentRoot /var/www/html/sibm/public
    
    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/www.smkbinamandiribekasi.sch.id/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/www.smkbinamandiribekasi.sch.id/privkey.pem
    
    # Security Headers
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    
    <Directory /var/www/html/sibm/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/smk-error.log
    CustomLog ${APACHE_LOG_DIR}/smk-access.log combined
</VirtualHost>
```

## Security Headers

### Additional Headers (Optional)
Add to `.htaccess` or Apache config:

```apache
# HSTS (HTTP Strict Transport Security)
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"

# Prevent clickjacking
Header always set X-Frame-Options "SAMEORIGIN"

# Prevent MIME sniffing
Header always set X-Content-Type-Options "nosniff"

# XSS Protection
Header always set X-XSS-Protection "1; mode=block"

# Referrer Policy
Header always set Referrer-Policy "strict-origin-when-cross-origin"

# Content Security Policy
Header always set Content-Security-Policy "default-src 'self' https:; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:;"
```

## Testing

### 1. Test HTTP to HTTPS Redirect
```bash
curl -I http://www.smkbinamandiribekasi.sch.id
# Should return: 301 Moved Permanently
# Location: https://www.smkbinamandiribekasi.sch.id
```

### 2. Test HTTPS Response
```bash
curl -I https://www.smkbinamandiribekasi.sch.id
# Should return: 200 OK
```

### 3. SSL Certificate Check
```bash
openssl s_client -connect www.smkbinamandiribekasi.sch.id:443 -servername www.smkbinamandiribekasi.sch.id
```

### 4. Online Tools
- **SSL Labs**: https://www.ssllabs.com/ssltest/
- **Why No Padlock**: https://www.whynopadlock.com/
- **Security Headers**: https://securityheaders.com/

## Environment-Specific Behavior

### Development (Local)
```env
APP_ENV=local
APP_URL=http://localhost:8000
```
- HTTPS not forced
- Works with `php artisan serve`

### Production (Server)
```env
APP_ENV=production
APP_URL=https://www.smkbinamandiribekasi.sch.id
```
- HTTPS forced
- All URLs use HTTPS

## Troubleshooting

### Issue: Mixed Content Warnings
**Problem**: Some resources load via HTTP

**Solution**:
```php
// Use asset() helper for all assets
<img src="{{ asset('images/logo.png') }}">
<link href="{{ asset('css/app.css') }}">

// Use route() for all routes
<a href="{{ route('home') }}">Home</a>

// Use url() for external links
<a href="{{ url('/about') }}">About</a>
```

### Issue: Infinite Redirect Loop
**Problem**: Too many redirects

**Solution**:
1. Check if behind proxy (Cloudflare, etc.)
2. Update TrustProxies middleware:
```php
// app/Http/Middleware/TrustProxies.php
protected $proxies = '*';
protected $headers = Request::HEADER_X_FORWARDED_ALL;
```

### Issue: Certificate Not Valid
**Problem**: SSL certificate errors

**Solution**:
1. Check certificate expiry
2. Verify domain matches certificate
3. Ensure intermediate certificates installed
4. Check certificate chain

## Performance Optimization

### Enable HTTP/2
```apache
# In Apache config
Protocols h2 http/1.1
```

### Enable OCSP Stapling
```apache
SSLUseStapling on
SSLStaplingCache "shmcb:logs/ssl_stapling(32768)"
```

### Enable Session Resumption
```apache
SSLSessionCache "shmcb:logs/ssl_scache(512000)"
SSLSessionCacheTimeout 300
```

## SEO Benefits

### HTTPS as Ranking Signal
- Google uses HTTPS as ranking factor
- Better search rankings
- Increased trust and credibility

### Update Google Search Console
1. Add HTTPS property
2. Submit new sitemap
3. Update robots.txt reference

### Update Sitemap
```xml
<!-- All URLs should use HTTPS -->
<url>
    <loc>https://www.smkbinamandiribekasi.sch.id/</loc>
</url>
```

## Maintenance

### Certificate Renewal
```bash
# Let's Encrypt auto-renews
# Check renewal status
sudo certbot certificates

# Manual renewal
sudo certbot renew

# Test renewal
sudo certbot renew --dry-run
```

### Monitor Certificate Expiry
- Set up monitoring alerts
- Check 30 days before expiry
- Automate renewal process

## Checklist

### Pre-Deployment
- [ ] SSL certificate obtained
- [ ] Certificate installed on server
- [ ] Apache/Nginx configured
- [ ] .env updated with HTTPS URL
- [ ] Code changes deployed

### Post-Deployment
- [ ] Test HTTP to HTTPS redirect
- [ ] Test all pages load via HTTPS
- [ ] Check for mixed content warnings
- [ ] Verify SSL certificate valid
- [ ] Test SSL Labs (A+ rating)
- [ ] Update Google Search Console
- [ ] Submit new sitemap
- [ ] Update social media links

## Files Modified

1. `.env` - APP_URL updated to HTTPS
2. `app/Http/Middleware/ForceHttps.php` - New middleware
3. `app/Http/Kernel.php` - Middleware registered
4. `app/Providers/AppServiceProvider.php` - URL force scheme
5. `public/.htaccess` - HTTPS redirect rules

## Status
✅ CONFIGURED - Application ready for HTTPS deployment

---

**Configuration Date**: January 18, 2025  
**Domain**: https://www.smkbinamandiribekasi.sch.id  
**Status**: Ready for production with SSL certificate

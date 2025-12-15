# Database Backup & Restore Feature

## Overview
Fitur backup dan restore database yang memungkinkan admin untuk membuat backup database, mengupload backup, dan melakukan restore dengan mudah melalui panel admin.

## Features

### 1. Create Backup
- Backup seluruh database dengan satu klik
- Otomatis generate filename dengan timestamp
- Menggunakan mysqldump untuk performa optimal
- Fallback ke Laravel DB jika mysqldump tidak tersedia

### 2. Upload Backup
- Upload file backup (.sql) dari komputer
- Validasi file type dan size (max 50MB)
- Otomatis rename dengan timestamp

### 3. Download Backup
- Download file backup ke komputer
- Simpan di tempat aman sebagai backup eksternal

### 4. Restore Database
- Restore database dari file backup
- Konfirmasi sebelum restore
- Otomatis clear cache setelah restore

### 5. Delete Backup
- Hapus file backup yang tidak diperlukan
- Konfirmasi sebelum delete
- Free up storage space

## Implementation

### 1. Controller
**File**: `app/Http/Controllers/Admin/BackupController.php`

**Methods**:
- `index()` - Tampilkan daftar backup
- `create()` - Buat backup baru
- `download($filename)` - Download backup
- `delete($filename)` - Hapus backup
- `restore(Request $request)` - Restore database
- `upload(Request $request)` - Upload backup file

### 2. View
**File**: `resources/views/admin/backup/index.blade.php`

**Sections**:
- Action cards (Create, Upload, Info)
- Backup list table
- Alert messages

### 3. Routes
**File**: `routes/web.php`

```php
Route::get('backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('backup/create', [BackupController::class, 'create'])->name('backup.create');
Route::get('backup/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
Route::delete('backup/delete/{filename}', [BackupController::class, 'delete'])->name('backup.delete');
Route::post('backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
Route::post('backup/upload', [BackupController::class, 'upload'])->name('backup.upload');
```

## Technical Details

### Backup Process

#### Using mysqldump (Primary Method)
```php
$command = sprintf(
    'mysqldump --user=%s --password=%s --host=%s %s > %s',
    escapeshellarg($username),
    escapeshellarg($password),
    escapeshellarg($host),
    escapeshellarg($database),
    escapeshellarg($filepath)
);
exec($command);
```

#### Using Laravel DB (Fallback)
```php
// Get all tables
$tables = DB::select('SHOW TABLES');

// For each table:
// 1. Get CREATE TABLE statement
// 2. Get all data
// 3. Generate INSERT statements
// 4. Write to file
```

### Restore Process

#### Using mysql (Primary Method)
```php
$command = sprintf(
    'mysql --user=%s --password=%s --host=%s %s < %s',
    escapeshellarg($username),
    escapeshellarg($password),
    escapeshellarg($host),
    escapeshellarg($database),
    escapeshellarg($filepath)
);
exec($command);
```

#### Using Laravel DB (Fallback)
```php
// Read SQL file
// Split into statements
// Execute each statement in transaction
```

### File Storage

#### Directory Structure
```
storage/
└── app/
    └── backups/
        ├── backup_2025-01-18_143022.sql
        ├── backup_2025-01-17_091530.sql
        └── uploaded_2025-01-16_120000_manual.sql
```

#### Filename Format
- **Auto backup**: `backup_YYYY-MM-DD_HHmmss.sql`
- **Uploaded**: `uploaded_YYYY-MM-DD_HHmmss_originalname.sql`

## Usage

### For Admin

#### 1. Access Backup Page
```
Admin Panel → Backup & Restore
URL: /admin/backup
```

#### 2. Create Backup
1. Click "Buat Backup" button
2. Confirm action
3. Wait for process to complete
4. Backup file will appear in list

#### 3. Upload Backup
1. Click "Pilih File" button
2. Select .sql file (max 50MB)
3. File will be uploaded automatically
4. Backup file will appear in list

#### 4. Download Backup
1. Find backup in list
2. Click "Download" button
3. Save file to computer

#### 5. Restore Database
1. Find backup in list
2. Click "Restore" button
3. **IMPORTANT**: Confirm action (will overwrite current data)
4. Wait for process to complete
5. System will clear cache automatically

#### 6. Delete Backup
1. Find backup in list
2. Click "Hapus" button
3. Confirm action
4. Backup file will be deleted

## Security

### Access Control
✅ **Admin Only** - Requires authentication  
✅ **CSRF Protection** - All forms protected  
✅ **Confirmation** - Restore and delete require confirmation  

### File Validation
✅ **Type Check** - Only .sql files allowed  
✅ **Size Limit** - Max 50MB for uploads  
✅ **Path Validation** - Prevent directory traversal  

### Database Security
✅ **Transaction** - Restore uses database transaction  
✅ **Rollback** - Auto rollback on error  
✅ **Credentials** - Uses config credentials securely  

## Best Practices

### Backup Schedule
- **Daily**: For active production sites
- **Weekly**: For moderate activity sites
- **Before Updates**: Always backup before major changes
- **Before Restore**: Create backup before restoring

### Storage Management
- Keep last 7-14 backups
- Delete old backups regularly
- Store important backups externally
- Use cloud storage for critical backups

### Restore Safety
1. **Test First**: Test restore on staging/development
2. **Backup Current**: Create backup before restore
3. **Verify Data**: Check data after restore
4. **Clear Cache**: System does this automatically

## Troubleshooting

### Issue: Backup Failed
**Possible Causes**:
- mysqldump not available
- Insufficient permissions
- Disk space full

**Solutions**:
- System will use Laravel fallback automatically
- Check file permissions on storage/app/backups
- Free up disk space

### Issue: Restore Failed
**Possible Causes**:
- Corrupted backup file
- Incompatible SQL syntax
- Database connection error

**Solutions**:
- Try different backup file
- Check database credentials
- Check error message for details

### Issue: Upload Failed
**Possible Causes**:
- File too large (>50MB)
- Wrong file type
- Upload timeout

**Solutions**:
- Compress large backups
- Ensure file is .sql format
- Increase PHP upload limits if needed

## Configuration

### PHP Settings (if needed)
```ini
; php.ini
upload_max_filesize = 50M
post_max_size = 50M
max_execution_time = 300
memory_limit = 256M
```

### Laravel Config
```php
// config/database.php
'mysql' => [
    'host' => env('DB_HOST', '127.0.0.1'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
],
```

## Benefits

### For School
✅ **Data Safety** - Protect against data loss  
✅ **Easy Recovery** - Quick restore when needed  
✅ **No Technical Skills** - Simple one-click operation  
✅ **Version Control** - Keep multiple backup versions  

### For Admin
✅ **Peace of Mind** - Know data is backed up  
✅ **Quick Action** - Fast backup and restore  
✅ **Flexible** - Upload external backups  
✅ **Transparent** - See all backups and details  

## Testing Checklist

- [ ] Create backup successfully
- [ ] Backup file created in storage/app/backups
- [ ] Backup appears in list with correct info
- [ ] Download backup works
- [ ] Upload backup (.sql) works
- [ ] Upload validation works (reject non-.sql)
- [ ] Upload size limit works (reject >50MB)
- [ ] Restore backup works
- [ ] Restore confirmation works
- [ ] Cache cleared after restore
- [ ] Delete backup works
- [ ] Delete confirmation works
- [ ] File actually deleted from storage
- [ ] Empty state shows when no backups
- [ ] Success/error messages display correctly

## Future Enhancements

### Possible Improvements
1. **Scheduled Backups** - Auto backup daily/weekly
2. **Cloud Storage** - Upload to S3, Google Drive, etc.
3. **Compression** - Compress backups to save space
4. **Encryption** - Encrypt sensitive backups
5. **Email Notifications** - Notify admin after backup
6. **Backup Verification** - Verify backup integrity
7. **Incremental Backups** - Only backup changes
8. **Multi-Database** - Backup multiple databases

## Status
✅ IMPLEMENTED - Backup & Restore feature fully functional

---

**Implementation Date**: January 18, 2025  
**Feature**: Database Backup & Restore  
**Status**: Completed

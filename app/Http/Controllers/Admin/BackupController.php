<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupController extends Controller
{
    public function index()
    {
        $backupPath = storage_path('app/backups');
        
        // Create backup directory if not exists
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        // Get all backup files
        $backups = collect(File::files($backupPath))
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $this->formatBytes($file->getSize()),
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                    'timestamp' => $file->getMTime(),
                ];
            })
            ->sortByDesc('timestamp')
            ->values();

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            $backupPath = storage_path('app/backups');
            
            // Create backup directory if not exists
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            // Generate backup filename
            $filename = 'backup_' . date('Y-m-d_His') . '.sql';
            $filepath = $backupPath . '/' . $filename;

            // Get database configuration
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            // Create mysqldump command
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($filepath)
            );

            // Execute backup
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Fallback: Use Laravel's DB facade
                $this->createBackupWithLaravel($filepath);
            }

            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    private function createBackupWithLaravel($filepath)
    {
        $tables = DB::select('SHOW TABLES');
        $database = config('database.connections.mysql.database');
        $tableKey = 'Tables_in_' . $database;

        $sql = "-- Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            // Get CREATE TABLE statement
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`");
            $sql .= "\n\n-- Table: $tableName\n";
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";
            $sql .= $createTable[0]->{'Create Table'} . ";\n\n";

            // Get table data
            $rows = DB::table($tableName)->get();
            
            if ($rows->count() > 0) {
                $sql .= "-- Data for table: $tableName\n";
                
                foreach ($rows as $row) {
                    $values = array_map(function ($value) {
                        return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                    }, (array) $row);
                    
                    $sql .= "INSERT INTO `$tableName` VALUES (" . implode(', ', $values) . ");\n";
                }
            }
        }

        File::put($filepath, $sql);
    }

    public function download($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!File::exists($filepath)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'File backup tidak ditemukan!');
        }

        return response()->download($filepath);
    }

    public function delete($filename)
    {
        try {
            $filepath = storage_path('app/backups/' . $filename);

            if (File::exists($filepath)) {
                File::delete($filepath);
                return redirect()->route('admin.backup.index')
                    ->with('success', 'Backup berhasil dihapus!');
            }

            return redirect()->route('admin.backup.index')
                ->with('error', 'File backup tidak ditemukan!');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal menghapus backup: ' . $e->getMessage());
        }
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|string',
        ]);

        try {
            $filepath = storage_path('app/backups/' . $request->backup_file);

            if (!File::exists($filepath)) {
                return redirect()->route('admin.backup.index')
                    ->with('error', 'File backup tidak ditemukan!');
            }

            // Get database configuration
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');

            // Create mysql restore command
            $command = sprintf(
                'mysql --user=%s --password=%s --host=%s %s < %s',
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($filepath)
            );

            // Execute restore
            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Fallback: Use Laravel's DB facade
                $this->restoreWithLaravel($filepath);
            }

            // Clear all caches after restore
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');

            return redirect()->route('admin.backup.index')
                ->with('success', 'Database berhasil di-restore!');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal restore database: ' . $e->getMessage());
        }
    }

    private function restoreWithLaravel($filepath)
    {
        $sql = File::get($filepath);
        
        // Split SQL into individual statements
        $statements = array_filter(
            array_map('trim', explode(';', $sql)),
            function ($statement) {
                return !empty($statement) && !str_starts_with($statement, '--');
            }
        );

        DB::beginTransaction();
        try {
            foreach ($statements as $statement) {
                if (!empty($statement)) {
                    DB::statement($statement);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql|max:51200', // Max 50MB
        ]);

        try {
            $file = $request->file('backup_file');
            $filename = 'uploaded_' . date('Y-m-d_His') . '_' . $file->getClientOriginalName();
            $backupPath = storage_path('app/backups');

            // Create backup directory if not exists
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            $file->move($backupPath, $filename);

            return redirect()->route('admin.backup.index')
                ->with('success', 'File backup berhasil diupload!');
        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal upload file: ' . $e->getMessage());
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

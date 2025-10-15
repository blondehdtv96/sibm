<?php

namespace App\Console\Commands;

use App\Services\AuditLogService;
use Illuminate\Console\Command;

class CleanAuditLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'audit:clean {--days=90 : Number of days to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old audit logs from the database';

    /**
     * Execute the console command.
     */
    public function handle(AuditLogService $auditLogService): int
    {
        $days = (int) $this->option('days');

        $this->info("Cleaning audit logs older than {$days} days...");

        $deleted = $auditLogService->cleanOldLogs($days);

        $this->info("Successfully deleted {$deleted} audit log records.");

        return Command::SUCCESS;
    }
}

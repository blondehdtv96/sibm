<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class DatabaseQueryOptimizationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only enable query logging in development or when explicitly enabled
        if (config('app.debug') || config('database.log_queries', false)) {
            $this->enableQueryLogging();
        }

        // Enable query optimization hints
        $this->enableQueryOptimization();
    }

    /**
     * Enable query logging for slow queries
     */
    protected function enableQueryLogging(): void
    {
        DB::listen(function (QueryExecuted $query) {
            // Log slow queries (over 1000ms)
            if ($query->time > 1000) {
                Log::warning('Slow query detected', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time . 'ms',
                    'connection' => $query->connectionName,
                ]);
            }

            // Log N+1 query problems in development
            if (config('app.debug')) {
                $this->detectNPlusOne($query);
            }
        });
    }

    /**
     * Detect potential N+1 query problems
     */
    protected function detectNPlusOne(QueryExecuted $query): void
    {
        static $queryCount = [];
        static $lastQuery = null;

        $sql = $query->sql;

        // Track similar queries
        if (!isset($queryCount[$sql])) {
            $queryCount[$sql] = 0;
        }
        $queryCount[$sql]++;

        // If the same query is executed more than 10 times, it might be N+1
        if ($queryCount[$sql] > 10 && $lastQuery !== $sql) {
            Log::warning('Potential N+1 query problem detected', [
                'sql' => $sql,
                'count' => $queryCount[$sql],
                'suggestion' => 'Consider using eager loading with with() or load()',
            ]);
            $lastQuery = $sql;
        }
    }

    /**
     * Enable query optimization
     */
    protected function enableQueryOptimization(): void
    {
        // Set default string length for MySQL
        \Illuminate\Database\Schema\Builder::defaultStringLength(191);

        // Enable strict mode for better data integrity
        if (config('database.connections.mysql')) {
            config([
                'database.connections.mysql.strict' => true,
                'database.connections.mysql.modes' => [
                    'STRICT_TRANS_TABLES',
                    'NO_ZERO_IN_DATE',
                    'NO_ZERO_DATE',
                    'ERROR_FOR_DIVISION_BY_ZERO',
                    'NO_ENGINE_SUBSTITUTION',
                ],
            ]);
        }
    }
}

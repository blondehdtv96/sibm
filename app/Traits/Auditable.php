<?php

namespace App\Traits;

use App\Services\AuditLogService;

trait Auditable
{
    /**
     * Boot the auditable trait
     */
    protected static function bootAuditable(): void
    {
        static::created(function ($model) {
            if (config('app.audit_enabled', true)) {
                app(AuditLogService::class)->logCreated($model);
            }
        });

        static::updated(function ($model) {
            if (config('app.audit_enabled', true)) {
                $oldValues = $model->getOriginal();
                app(AuditLogService::class)->logUpdated($model, $oldValues);
            }
        });

        static::deleted(function ($model) {
            if (config('app.audit_enabled', true)) {
                app(AuditLogService::class)->logDeleted($model);
            }
        });
    }

    /**
     * Get all audit logs for this model
     */
    public function auditLogs()
    {
        return $this->morphMany(\App\Models\AuditLog::class, 'model');
    }
}

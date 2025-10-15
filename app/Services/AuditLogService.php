<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * Log an action
     *
     * @param string $action
     * @param Model|null $model
     * @param array $oldValues
     * @param array $newValues
     * @return AuditLog
     */
    public function log(
        string $action,
        ?Model $model = null,
        array $oldValues = [],
        array $newValues = []
    ): AuditLog {
        return AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'old_values' => $this->sanitizeValues($oldValues),
            'new_values' => $this->sanitizeValues($newValues),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'url' => Request::fullUrl(),
        ]);
    }

    /**
     * Log a model creation
     *
     * @param Model $model
     * @return AuditLog
     */
    public function logCreated(Model $model): AuditLog
    {
        return $this->log(
            'created',
            $model,
            [],
            $model->getAttributes()
        );
    }

    /**
     * Log a model update
     *
     * @param Model $model
     * @param array $oldValues
     * @return AuditLog
     */
    public function logUpdated(Model $model, array $oldValues): AuditLog
    {
        return $this->log(
            'updated',
            $model,
            $oldValues,
            $model->getAttributes()
        );
    }

    /**
     * Log a model deletion
     *
     * @param Model $model
     * @return AuditLog
     */
    public function logDeleted(Model $model): AuditLog
    {
        return $this->log(
            'deleted',
            $model,
            $model->getAttributes(),
            []
        );
    }

    /**
     * Log a login attempt
     *
     * @param bool $successful
     * @param string|null $email
     * @return AuditLog
     */
    public function logLogin(bool $successful, ?string $email = null): AuditLog
    {
        return $this->log(
            $successful ? 'login_success' : 'login_failed',
            null,
            [],
            ['email' => $email]
        );
    }

    /**
     * Log a logout
     *
     * @return AuditLog
     */
    public function logLogout(): AuditLog
    {
        return $this->log('logout');
    }

    /**
     * Log a password change
     *
     * @return AuditLog
     */
    public function logPasswordChange(): AuditLog
    {
        return $this->log('password_changed');
    }

    /**
     * Log a file upload
     *
     * @param string $filename
     * @param string $path
     * @return AuditLog
     */
    public function logFileUpload(string $filename, string $path): AuditLog
    {
        return $this->log(
            'file_uploaded',
            null,
            [],
            ['filename' => $filename, 'path' => $path]
        );
    }

    /**
     * Log a file deletion
     *
     * @param string $path
     * @return AuditLog
     */
    public function logFileDelete(string $path): AuditLog
    {
        return $this->log(
            'file_deleted',
            null,
            ['path' => $path],
            []
        );
    }

    /**
     * Log a permission change
     *
     * @param Model $user
     * @param string $oldRole
     * @param string $newRole
     * @return AuditLog
     */
    public function logPermissionChange(Model $user, string $oldRole, string $newRole): AuditLog
    {
        return $this->log(
            'permission_changed',
            $user,
            ['role' => $oldRole],
            ['role' => $newRole]
        );
    }

    /**
     * Log a security event
     *
     * @param string $event
     * @param array $details
     * @return AuditLog
     */
    public function logSecurityEvent(string $event, array $details = []): AuditLog
    {
        return $this->log(
            'security_' . $event,
            null,
            [],
            $details
        );
    }

    /**
     * Sanitize values to remove sensitive data
     *
     * @param array $values
     * @return array
     */
    protected function sanitizeValues(array $values): array
    {
        $sensitiveKeys = [
            'password',
            'password_confirmation',
            'remember_token',
            'api_token',
            'secret',
            'private_key',
        ];

        foreach ($sensitiveKeys as $key) {
            if (isset($values[$key])) {
                $values[$key] = '[REDACTED]';
            }
        }

        return $values;
    }

    /**
     * Get recent audit logs
     *
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentLogs(int $limit = 50)
    {
        return AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get logs for a specific user
     *
     * @param int $userId
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserLogs(int $userId, int $limit = 50)
    {
        return AuditLog::byUser($userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get logs for a specific model
     *
     * @param Model $model
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getModelLogs(Model $model, int $limit = 50)
    {
        return AuditLog::where('model_type', get_class($model))
            ->where('model_id', $model->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get security-related logs
     *
     * @param int $days
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSecurityLogs(int $days = 7)
    {
        return AuditLog::where('action', 'like', 'security_%')
            ->orWhere('action', 'like', 'login_%')
            ->orWhere('action', 'logout')
            ->orWhere('action', 'password_changed')
            ->orWhere('action', 'permission_changed')
            ->recent($days)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Clean old audit logs
     *
     * @param int $days
     * @return int Number of deleted records
     */
    public function cleanOldLogs(int $days = 90): int
    {
        return AuditLog::where('created_at', '<', now()->subDays($days))->delete();
    }
}

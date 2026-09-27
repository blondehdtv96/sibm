<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Model untuk menyimpan riwayat percakapan chatbot
 */
class Chat extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi mass assignment
     */
    protected $fillable = [
        'session_id',
        'user_message',
        'bot_reply',
        'ip_address',
        'user_agent',
    ];

    /**
     * Scope untuk filter berdasarkan session
     */
    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope untuk mendapatkan chat terbaru
     */
    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }

    /**
     * Berapa hari riwayat chat disimpan sebelum dihapus otomatis.
     * Nilai 0 berarti tanpa batas waktu.
     */
    public static function retentionDays(): int
    {
        return max(0, (int) config('school.chatbot.retention_days', 7));
    }

    /**
     * Scope untuk chat yang sudah melewati masa simpan.
     */
    public function scopeExpired($query, ?int $days = null)
    {
        $days = $days ?? self::retentionDays();

        if ($days <= 0) {
            // Tanpa batas waktu: jangan pilih baris apa pun.
            return $query->whereRaw('1 = 0');
        }

        return $query->where('created_at', '<', now()->subDays($days));
    }

    /**
     * Hapus riwayat chat yang sudah lewat masa simpan.
     *
     * @return int Jumlah baris yang dihapus.
     */
    public static function purgeExpired(?int $days = null): int
    {
        $days = $days ?? self::retentionDays();

        if ($days <= 0) {
            return 0;
        }

        $deleted = 0;

        // Hapus bertahap supaya tidak mengunci tabel bila datanya banyak.
        do {
            $batch = static::expired($days)->limit(1000)->delete();
            $deleted += $batch;
        } while ($batch > 0);

        return $deleted;
    }
}

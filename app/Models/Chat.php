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
}

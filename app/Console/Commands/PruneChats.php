<?php

namespace App\Console\Commands;

use App\Models\Chat;
use Illuminate\Console\Command;

/**
 * Menghapus riwayat percakapan chatbot yang sudah melewati masa simpan
 * (default 7 hari, diatur lewat CHAT_RETENTION_DAYS).
 */
class PruneChats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:prune {--days= : Jumlah hari riwayat chat disimpan (default dari konfigurasi)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus riwayat chatbot yang lebih lama dari masa simpan (default 7 hari)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = $this->option('days') !== null
            ? (int) $this->option('days')
            : Chat::retentionDays();

        if ($days <= 0) {
            $this->warn('Masa simpan diatur tanpa batas (0 hari), tidak ada riwayat chat yang dihapus.');

            return Command::SUCCESS;
        }

        $this->info("Menghapus riwayat chat yang lebih lama dari {$days} hari...");

        $deleted = Chat::purgeExpired($days);

        $this->info("Selesai. {$deleted} baris riwayat chat dihapus.");

        return Command::SUCCESS;
    }
}

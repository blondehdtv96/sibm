<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatbotResponse;
use App\Models\Competency;
use App\Models\PpdbSetting;
use App\Models\Setting;
use App\Services\SchoolAssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Controller chatbot publik.
 *
 * AI (SchoolAssistantService) adalah otak utama: setiap pertanyaan dijawab
 * otomatis oleh AI yang sudah dibekali seluruh isi website sebagai konteks.
 * Jika AI belum dikonfigurasi atau gagal dihubungi, controller jatuh ke
 * balasan cadangan yang tetap memakai data asli dari database/pengaturan
 * sekolah (bukan data karangan).
 */
class ChatbotController extends Controller
{
    public function __construct(private SchoolAssistantService $assistant)
    {
    }

    /**
     * Proses pesan dari user dan kirim balasan.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string|max:64',
        ]);

        $userMessage = trim($request->input('message'));
        $sessionId = (string) ($request->input('session_id') ?? Str::uuid());

        [$botReply, $source] = $this->processMessage($userMessage, $sessionId);

        Chat::create([
            'session_id' => $sessionId,
            'user_message' => $userMessage,
            'bot_reply' => $botReply,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $this->purgeExpiredChats();

        return response()->json([
            'success' => true,
            'message' => $botReply,
            'session_id' => $sessionId,
            'source' => $source,
        ]);
    }

    /**
     * Bersihkan riwayat chat yang sudah lewat masa simpan (default 7 hari).
     *
     * Dijalankan paling banyak sekali sehari dari sisi web sebagai cadangan,
     * supaya riwayat tetap terhapus walau scheduler (cron) belum diaktifkan.
     * Penjadwalan utamanya tetap lewat command `chat:prune`.
     */
    private function purgeExpiredChats(): void
    {
        if (Chat::retentionDays() <= 0) {
            return;
        }

        try {
            // Cache::add hanya berhasil bila kunci belum ada, jadi pembersihan
            // tidak berjalan berulang-ulang pada setiap pesan masuk.
            if (! Cache::add('chatbot_last_purge_at', now()->toDateTimeString(), now()->addDay())) {
                return;
            }

            $deleted = Chat::purgeExpired();

            if ($deleted > 0) {
                Log::info("Riwayat chatbot kedaluwarsa dihapus otomatis: {$deleted} baris.");
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal menghapus riwayat chat kedaluwarsa: ' . $e->getMessage());
        }
    }

    /**
     * AI menjawab lebih dulu; fallback dipakai hanya bila AI tidak tersedia.
     *
     * @return array{0: string, 1: string} Balasan dan asal balasan (ai|fallback).
     */
    private function processMessage(string $message, string $sessionId): array
    {
        if ($this->assistant->isConfigured()) {
            try {
                return [$this->assistant->reply($message, $this->buildHistory($sessionId)), 'ai'];
            } catch (\Throwable $e) {
                Log::warning('Chatbot AI gagal, fallback ke balasan cadangan: ' . $e->getMessage());
            }
        }

        return [$this->fallbackReply($message), 'fallback'];
    }

    /**
     * Ambil beberapa pesan terakhir pada sesi ini sebagai konteks percakapan untuk AI.
     *
     * @return array<int, array{role: string, content: string}>
     */
    private function buildHistory(string $sessionId): array
    {
        try {
            $recentChats = Chat::bySession($sessionId)
                ->latest('id')
                ->limit(5)
                ->get()
                ->reverse();
        } catch (\Throwable $e) {
            return [];
        }

        $history = [];
        foreach ($recentChats as $chat) {
            $history[] = ['role' => 'user', 'content' => $chat->user_message];
            $history[] = ['role' => 'assistant', 'content' => $chat->bot_reply];
        }

        return $history;
    }

    /**
     * Balasan cadangan saat AI tidak dapat dipakai.
     * Seluruh isinya diambil dari database/pengaturan agar tetap akurat.
     */
    private function fallbackReply(string $message): string
    {
        $message = Str::lower($message);

        if ($dbResponse = $this->checkDatabaseResponses($message)) {
            return $dbResponse;
        }

        if ($this->containsKeywords($message, ['halo', 'hai', 'hello', 'hi ', 'assalamualaikum', 'pagi', 'siang', 'sore', 'malam'])) {
            return 'Halo! 😊 Selamat datang di ' . $this->schoolName() . ". Ada yang bisa saya bantu? Anda bisa bertanya soal program keahlian, pendaftaran SPMB, berita sekolah, atau kontak sekolah.";
        }

        if ($this->containsKeywords($message, ['terima kasih', 'makasih', 'thanks', 'thank you'])) {
            return 'Sama-sama! 😊 Kalau ada pertanyaan lain seputar ' . $this->schoolName() . ', silakan tanya lagi ya.';
        }

        if ($this->containsKeywords($message, ['jurusan', 'program keahlian', 'kompetensi keahlian'])) {
            return $this->competencyInfo();
        }

        if ($this->containsKeywords($message, ['ppdb', 'spmb', 'pendaftaran', 'daftar', 'syarat'])) {
            return $this->ppdbInfo();
        }

        if ($this->containsKeywords($message, ['alamat', 'lokasi', 'kontak', 'telepon', 'email', 'whatsapp', 'dimana'])) {
            return $this->contactInfo();
        }

        return "Maaf, asisten AI sedang tidak dapat dihubungi sehingga saya belum bisa menjawab pertanyaan itu. 🙏\n\n"
            . "Sementara ini Anda bisa bertanya soal **program keahlian**, **pendaftaran SPMB**, atau **kontak sekolah**.\n\n"
            . $this->contactInfo();
    }

    private function schoolName(): string
    {
        return (string) $this->setting('site_name', config('school.name'));
    }

    private function competencyInfo(): string
    {
        try {
            $competencies = Competency::active()->ordered()->get(['name', 'slug']);
        } catch (\Throwable $e) {
            $competencies = collect();
        }

        if ($competencies->isEmpty()) {
            return 'Data program keahlian sedang tidak dapat dimuat. Silakan lihat langsung di ' . route('public.competencies.index') . ' 🙏';
        }

        return "📚 **Program Keahlian di " . $this->schoolName() . ":**\n\n"
            . $competencies->map(fn ($item) => '• ' . $item->name)->implode("\n")
            . "\n\nDetail tiap jurusan: " . route('public.competencies.index');
    }

    private function ppdbInfo(): string
    {
        try {
            $ppdb = PpdbSetting::current();
        } catch (\Throwable $e) {
            $ppdb = null;
        }

        $text = "📝 **Pendaftaran Peserta Didik Baru (SPMB)**\n\n";

        if ($ppdb) {
            $status = $ppdb->isOpen() ? 'sedang dibuka ✅' : ($ppdb->isUpcoming() ? 'belum dibuka ⏳' : 'sudah ditutup ❌');
            $text .= "Status saat ini: **{$status}**\nPeriode: {$ppdb->formatted_period}\n";

            if (! empty($ppdb->requirements)) {
                $text .= "\nPersyaratan:\n" . collect($ppdb->requirements)->map(fn ($item) => '✅ ' . $item)->implode("\n") . "\n";
            }
        } else {
            $text .= "Jadwal pendaftaran terbaru belum dipublikasikan di website.\n";
        }

        return $text . "\nDaftar online: " . route('ppdb.register')
            . "\nCek status pendaftaran: " . route('ppdb.check-status');
    }

    private function contactInfo(): string
    {
        $school = config('school');

        return "📍 **Kontak " . $this->schoolName() . "**\n\n"
            . '🏫 ' . $this->setting('contact_address', $school['address']) . "\n"
            . '📞 ' . $this->setting('contact_phone', $school['phone']) . "\n"
            . '📱 WhatsApp: ' . $this->setting('contact_whatsapp', $school['whatsapp']) . "\n"
            . '📧 ' . $this->setting('contact_email', $school['email']) . "\n"
            . '🌐 ' . route('info.contact');
    }

    private function setting(string $key, $default = '')
    {
        try {
            $value = Setting::get($key, $default);
        } catch (\Throwable $e) {
            return $default;
        }

        return blank($value) ? $default : $value;
    }

    /**
     * Cek balasan yang dikelola admin di database.
     */
    private function checkDatabaseResponses(string $message): ?string
    {
        try {
            $responses = ChatbotResponse::active()->byPriority()->get();
        } catch (\Throwable $e) {
            return null;
        }

        foreach ($responses as $response) {
            $keywords = is_array($response->keywords) ? $response->keywords : [$response->keywords];

            if ($this->containsKeywords($message, $keywords)) {
                return $response->response;
            }
        }

        return null;
    }

    /**
     * Helper untuk mengecek keberadaan kata kunci di dalam pesan.
     *
     * @param  array<int, string>|string  $keywords
     */
    private function containsKeywords(string $message, $keywords): bool
    {
        foreach ((array) $keywords as $keyword) {
            $keyword = trim((string) $keyword);

            if ($keyword !== '' && stripos($message, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
}

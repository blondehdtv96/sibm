<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Competency;
use App\Models\IndustryPartner;
use App\Models\PpdbSetting;
use App\Models\Setting;
use App\Models\Statistic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Menjawab pertanyaan seputar SMK Bina Mandiri Kota Bekasi menggunakan AI (OpenAI-compatible
 * chat completion API), dibekali data resmi sekolah agar jawaban tidak mengarang informasi.
 */
class SchoolAssistantService
{
    /**
     * Jumlah pasangan pesan (user + assistant) dari riwayat yang disertakan sebagai konteks.
     */
    private const HISTORY_LIMIT = 6;

    public function isConfigured(): bool
    {
        return filled(config('services.openai.api_key'));
    }

    /**
     * Kirim pesan pengguna beserta riwayat percakapan ke AI dan kembalikan balasannya.
     *
     * @param  array<int, array{role: string, content: string}>  $history
     *
     * @throws \RuntimeException
     */
    public function reply(string $message, array $history = []): string
    {
        if (! $this->isConfigured()) {
            throw new \RuntimeException('OpenAI API key belum dikonfigurasi.');
        }

        $messages = array_merge(
            [['role' => 'system', 'content' => $this->systemPrompt()]],
            $history,
            [['role' => 'user', 'content' => $message]]
        );

        $baseUrl = rtrim((string) config('services.openai.base_url', 'https://api.openai.com/v1'), '/');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.openai.api_key'),
            'Content-Type' => 'application/json',
        ])
            ->timeout((int) config('services.openai.timeout', 30))
            ->post($baseUrl . '/chat/completions', [
                'model' => config('services.openai.model', 'gpt-4o-mini'),
                'messages' => $messages,
                'max_tokens' => (int) config('services.openai.max_tokens', 500),
                'temperature' => (float) config('services.openai.temperature', 0.4),
            ]);

        if (! $response->successful()) {
            Log::warning('Chatbot AI request failed', [
                'status' => $response->status(),
                'body' => Str::limit($response->body(), 500),
            ]);

            throw new \RuntimeException('Permintaan ke layanan AI gagal.');
        }

        $content = trim((string) $response->json('choices.0.message.content'));

        if ($content === '') {
            throw new \RuntimeException('Respons AI kosong.');
        }

        return $content;
    }

    /**
     * Bangun system prompt berisi data resmi sekolah, di-cache singkat agar tidak query berulang.
     */
    public function systemPrompt(): string
    {
        return Cache::remember('chatbot_ai_system_prompt', 300, fn () => $this->buildSystemPrompt());
    }

    private function buildSystemPrompt(): string
    {
        $school = config('school');

        $contact = [
            'address' => Setting::get('contact_address', $school['address']),
            'phone' => Setting::get('contact_phone', $school['phone']),
            'email' => Setting::get('contact_email', $school['email']),
            'whatsapp' => Setting::get('contact_whatsapp', $school['whatsapp']),
            'website' => $school['website'],
        ];

        $ppdb = PpdbSetting::current();
        $ppdbInfo = 'Informasi periode SPMB belum dipublikasikan. Arahkan pengguna menghubungi sekolah melalui kontak resmi untuk info terbaru.';
        if ($ppdb) {
            $status = $ppdb->isOpen() ? 'SEDANG DIBUKA' : ($ppdb->isUpcoming() ? 'BELUM DIBUKA' : 'SUDAH DITUTUP');
            $ppdbInfo = "Status pendaftaran SPMB saat ini: {$status}. Periode resmi: {$ppdb->formatted_period}.";
            if (! empty($ppdb->requirements)) {
                $ppdbInfo .= ' Dokumen yang dibutuhkan: ' . implode(', ', $ppdb->requirements) . '.';
            }
        }

        $competencies = Competency::active()->ordered()->get(['name', 'description'])
            ->map(fn ($c) => '- ' . $c->name . ': ' . Str::limit(strip_tags((string) $c->description), 150))
            ->implode("\n");
        if ($competencies === '') {
            $competencies = 'Data program keahlian belum tersedia di sistem.';
        }

        $partners = IndustryPartner::active()->ordered()->pluck('name');
        if ($partners->isEmpty()) {
            $partners = collect($school['industry_partners'] ?? []);
        }
        $partnerList = $partners->isEmpty() ? 'Belum ada data mitra industri.' : $partners->implode(', ');

        $announcements = Announcement::active()->ordered()->limit(5)->pluck('title')
            ->map(fn ($title) => '- ' . $title)
            ->implode("\n");
        if ($announcements === '') {
            $announcements = 'Tidak ada pengumuman aktif saat ini.';
        }

        $statistics = Statistic::active()->get()
            ->map(fn ($s) => "{$s->label}: {$s->value}{$s->suffix}")
            ->implode(', ');
        if ($statistics === '') {
            $statistics = "Siswa aktif: {$school['facts']['active_students']}, Guru: {$school['facts']['teachers']}, Program keahlian: {$school['facts']['programs']}";
        }

        return <<<PROMPT
Kamu adalah asisten virtual resmi {$school['name']} ("{$school['tagline']}"). Jawab dalam Bahasa Indonesia dengan ramah, singkat, dan jelas. Gunakan HANYA data resmi di bawah ini sebagai sumber kebenaran. Jangan pernah mengarang angka, tanggal, alamat, atau fakta lain yang tidak tercantum di sini. Jika informasi yang ditanyakan tidak ada di data ini, katakan dengan jujur bahwa kamu belum memiliki informasi tersebut dan arahkan pengguna menghubungi sekolah melalui kontak resmi.

=== DATA RESMI SEKOLAH ===
Nama: {$school['name']}
Slogan: {$school['tagline']}
Berdiri sejak: {$school['founded_year']}
Alamat: {$contact['address']}
Telepon: {$contact['phone']}
Email: {$contact['email']}
WhatsApp: {$contact['whatsapp']}
Website: {$contact['website']}

Statistik terverifikasi: {$statistics}

=== PROGRAM KEAHLIAN ===
{$competencies}

=== MITRA INDUSTRI / DUNIA KERJA ===
{$partnerList}

=== INFORMASI SPMB ===
{$ppdbInfo}
Untuk mendaftar, arahkan pengguna ke halaman "Daftar SPMB" di website resmi sekolah.

=== PENGUMUMAN AKTIF ===
{$announcements}

Aturan tambahan:
1. Jika pertanyaan di luar topik sekolah (politik, hal pribadi, topik umum tidak terkait), tolak dengan sopan dan arahkan kembali ke topik seputar sekolah.
2. Jangan pernah memberikan data pribadi siswa/guru, nomor rekening, atau informasi yang tidak tercantum di atas.
3. Jawaban singkat dan mudah dibaca, emoji secukupnya, hindari paragraf yang terlalu panjang.
4. Jika ditanya cara mendaftar SPMB, arahkan ke halaman pendaftaran resmi di website.
PROMPT;
    }
}

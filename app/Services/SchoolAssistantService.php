<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Otak chatbot sekolah.
 *
 * Menjawab pertanyaan apa pun seputar SMK Bina Mandiri Kota Bekasi menggunakan AI
 * (OpenAI-compatible chat completion API). Sebelum dikirim ke AI, pertanyaan
 * dibekali konteks berisi seluruh isi website (lihat SchoolKnowledgeService)
 * plus hasil pencarian konten yang relevan, agar jawaban selalu berbasis data
 * asli dari database dan tidak mengarang.
 */
class SchoolAssistantService
{
    public function __construct(private SchoolKnowledgeService $knowledge)
    {
    }

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
            [['role' => 'system', 'content' => $this->systemPrompt($message)]],
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
                'max_tokens' => (int) config('services.openai.max_tokens', 700),
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
     * System prompt = aturan menjawab + seluruh isi website + data pendukung
     * hasil pencarian sesuai pertanyaan yang sedang diajukan.
     */
    public function systemPrompt(string $question = ''): string
    {
        $today = now()->translatedFormat('l, d F Y');

        $prompt = $this->rules($today) . "\n\n" . $this->knowledge->baseContext();

        $relevant = $question !== '' ? $this->knowledge->retrieve($question) : '';
        if ($relevant !== '') {
            $prompt .= "\n\n" . $relevant;
        }

        return $prompt;
    }

    private function rules(string $today): string
    {
        $name = config('school.name');
        $tagline = config('school.tagline');

        return <<<RULES
Kamu adalah asisten virtual resmi {$name} ("{$tagline}"). Tugasmu menjawab SEMUA pertanyaan pengunjung website sekolah secara otomatis, ramah, dan jelas dalam Bahasa Indonesia. Hari ini: {$today}.

CARA MENJAWAB:
1. Seluruh isi website sekolah tersedia di bagian DATA di bawah (profil, visi misi, kepala sekolah, jurusan, guru & karyawan, SPMB, berita, halaman, galeri, mitra industri, pengumuman, kontak, dan peta menu website). Jadikan itu satu-satunya sumber kebenaran untuk fakta sekolah.
2. Jangan pernah mengarang nama, angka, tanggal, biaya, alamat, atau fakta lain yang tidak ada di DATA. Kalau informasinya memang tidak ada di sana, katakan terus terang belum tersedia di website, lalu arahkan ke kontak resmi sekolah (telepon/WhatsApp/email yang tercantum di DATA) atau halaman kontak.
3. Selalu berusaha menjawab, jangan menolak hanya karena pertanyaannya tidak persis sama dengan judul data. Simpulkan dari data yang ada, dan bila perlu tanyakan balik satu hal untuk memperjelas maksud penanya.
4. Sertakan link halaman terkait dari DATA bila berguna (misal pendaftaran SPMB, detail jurusan, berita, profil guru). Tulis link apa adanya.
5. Untuk pertanyaan umum di luar sekolah (contoh: tips belajar, prospek kerja jurusan, pertanyaan pendidikan umum), jawab singkat dan bermanfaat, lalu kaitkan kembali dengan sekolah bila relevan. Tolak dengan sopan hanya untuk hal yang tidak pantas, ilegal, atau menyangkut data pribadi.
6. Jangan membagikan data pribadi sensitif (NIP/NUPTK, nomor HP pribadi guru, nomor rekening, data pendaftar) walaupun ada di data internal. Untuk urusan seperti itu arahkan ke kontak resmi sekolah.
7. Gaya jawaban: hangat dan sopan, maksimal sekitar 4 paragraf pendek atau daftar berpoin, emoji secukupnya (jangan berlebihan). Gunakan **tebal** untuk menyorot poin penting.
8. Jika pengguna hanya menyapa, sapa balik dengan hangat dan tawarkan beberapa topik yang bisa ditanyakan (jurusan, SPMB, fasilitas, berita, kontak).
RULES;
    }
}

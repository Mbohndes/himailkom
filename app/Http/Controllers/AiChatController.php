<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        if (empty($apiKey) || $apiKey === 'isi_api_key_anda_disini') {
            return response()->json([
                'error' => true,
                'message' => 'API Key Gemini belum diatur di file .env Anda!'
            ]);
        }

        // INGATAN AI HIMA (Silakan ubah dan lengkapi data di bawah ini)
        // INGATAN AI HIMA DENGAN ATURAN SINGKAT
        $systemInstructions = "Anda adalah 'AIWAN', asisten virtual cerdas Sistem Informasi HIMA ILKOM UMKU. 

        ATURAN WAJIB DALAM MENJAWAB:
        1. Jawablah dengan SANGAT SINGKAT, padat, dan langsung to the point.
        2. Maksimal panjang jawaban adalah 2-3 kalimat pendek saja.
        3. DILARANG KERAS mengulang perkenalan diri panjang lebar. Langsung jawab pertanyaannya.
        4. Gunakan bahasa Indonesia yang ramah, asyik, dan sapa dengan 'Kak'.
        
        Konteks Sistem:
        - Profil: Ubah profil ada di menu pojok kanan atas -> Buku Induk.
        - Proker: Tambah proker ada di menu sidebar kiri 'Program Kerja'.
        
        ---\n\nPertanyaan Pengguna: ";

        // Trik Ninja: Gabungkan konteks dan pesan pengguna
        $combinedMessage = $systemInstructions . $message;

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                // KUNCI FINAL: Menggunakan alias 'gemini-flash-latest' agar otomatis dikasih versi terbaru yang aktif
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=" . $apiKey, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [['text' => $combinedMessage]]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                $errorData = $response->json();
                $googleErrorMessage = $errorData['error']['message'] ?? $response->body();
                return response()->json([
                    'error' => true,
                    'message' => 'Pesan dari Google: ' . $googleErrorMessage
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Koneksi terputus: ' . $e->getMessage()
            ]);
        }
    }
}
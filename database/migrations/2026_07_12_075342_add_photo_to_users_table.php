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

        // "INGATAN" AI: Ini adalah konteks yang akan selalu diingat AI
        $systemInstructions = "Anda adalah asisten virtual cerdas untuk Sistem Informasi HIMA ILKOM. 
        Tugas Anda adalah membantu pengurus menjawab pertanyaan tentang penggunaan sistem, 
        seperti cara update profil, cara tambah proker, atau penggunaan fitur lainnya. 
        Gunakan bahasa Indonesia yang ramah dan formal. 
        Jika ada pertanyaan di luar topik HIMA, arahkan kembali ke HIMA.";

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$apiKey", [
                'contents' => [['parts' => [['text' => $message]]]],
                'system_instruction' => ['parts' => [['text' => $systemInstructions]]]
            ]);

        return response()->json($response->json());
    }
}
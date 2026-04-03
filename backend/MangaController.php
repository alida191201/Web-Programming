<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MangaComment;
use App\Models\MangaLike;

class MangaController extends Controller
{
    public function index()
    {
        $apiKey = 'aefc91517cmsha9f6dc0a9f4bc98p18a8e7jsn012ebc79a359';
        $host = 'mangaverse-api.p.rapidapi.com';

        $url = 'https://mangaverse-api.p.rapidapi.com/manga/fetch';

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => $apiKey,
            'X-RapidAPI-Host' => $host,
        ])->get($url, [
            'page' => 1,
            'nsfw' => 'false',
            'type' => 'all'
        ]);

        if (!$response->successful()) {
            return view('manga_top', [
                'mangas' => [],
                'error' => 'Errore API: ' . $response->status()
            ]);
        }

        $data = $response->json();

        
        $mangas = $data['data'] ?? [];

        return view('manga_top', compact('mangas'));
    }

    public function like($id)
    {
        $like = MangaLike::firstOrCreate([
            'post_id' => $id,
            'user_id' => auth()->id() ?? 0,
        ]);

        return response()->json([
            'likes' => MangaLike::where('post_id', $id)->count(),
        ]);
    }

    public function comment(Request $request, $id)
    {
        MangaComment::create([
            'post_id' => $id,
            'user_id' => auth()->id() ?? null,
            'content' => $request->comment,
        ]);

        return response()->json(['success' => true]);
    }
}

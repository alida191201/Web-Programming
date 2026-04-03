<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\AnimeLike;
use App\Models\AnimeComment;

class AnimeController extends Controller
{
  

public function index()
{
    $animes = [];
    try {
        $r = Http::timeout(10)->get('https://api.jikan.moe/v4/top/anime');
        $animes = $r->successful() ? ($r->json()['data'] ?? []) : [];
    } catch (\Throwable $e) {
        Log::error('Jikan error: '.$e->getMessage());
    }

    
    foreach ($animes as &$anime) {
        $anime['likes'] = AnimeLike::where('anime_id', $anime['mal_id'])->count();
    }

    return view('anime.top', compact('animes'));
}


   public function like(Request $request, $id)
{
    $userId = auth()->id() ?? 0; // usa 0 per i guest

    AnimeLike::firstOrCreate([
        'user_id' => $userId,
        'anime_id' => (int) $id,
    ]);

    $count = AnimeLike::where('anime_id', (int) $id)->count();

    return response()->json(['likes' => $count]);
}


    public function comment(Request $request, $id)
    {
        $request->validate(['comment' => 'required|string|max:500']);

        $user = $request->user(); 
        $cmt  = AnimeComment::create([
            'user_id'  => optional($user)->id,    // null se guest
            'anime_id' => (int) $id ?? 1,
            'content'  => $request->input('comment'),
        ]);
        

        return response()->json([
            'user'    => optional($user)->name ?? 'Anonimo',
            'comment' => $cmt->content,
        ], 201);
    }
    public function getComments($id)
{
    $comments = \App\Models\AnimeComment::where('anime_id', (int) $id)
      ->latest()
      ->get();


}

}

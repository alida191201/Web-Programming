<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MangaComment;
use App\Models\AnimeComment;
use App\Models\MangaLike;
use App\Models\AnimeLike;

class HomeController extends Controller
{
    public function index()
    {
        $latestComments = collect()
            ->merge(MangaComment::with('user')->latest()->take(5)->get())
            ->merge(AnimeComment::with('user')->latest()->take(5)->get())
            ->sortByDesc('created_at')
            ->take(5);

        $latestLikes = collect()
            ->merge(MangaLike::with('user')->latest()->take(5)->get())
            ->merge(AnimeLike::with('user')->latest()->take(5)->get())
            ->sortByDesc('created_at')
            ->take(5);

        return view('home', [
            'latestComments' => $latestComments,
            'latestLikes' => $latestLikes,
        ]);
    }
}

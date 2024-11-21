<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke()
    {
        $mostLiked = Recipe::withCount('likes')->orderBy('likes_count', 'desc')->take(5)->get();
        $new = Recipe::orderBy('created_At', 'desc')->take(5)->get();


        // dd($mostLiked, $new);
        return view('home',compact('mostLiked','new'));
    }
}

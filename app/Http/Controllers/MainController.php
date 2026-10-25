<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MainController extends Controller
{
    public function index()
    {
        $path = public_path('articles.json');
        $articles = [];
        if (File::exists($path)) {
            $articles = json_decode(File::get($path), true);
        }

        return view('home', ['articles' => $articles]);
    }

    public function galery($id)
    {
        $path = public_path('articles.json');
        $articles = File::exists($path) ? json_decode(File::get($path), true) : [];

        if (!isset($articles[$id])) {
            abort(404);
        }

        return view('galery', ['article' => $articles[$id]]);
    }
}
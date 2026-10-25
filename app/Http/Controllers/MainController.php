<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MainController extends Controller
{
    // Метод чтения JSON-файла и отправки данных на главную страницу
    public function index()
    {
        $path = public_path('articles.json');
        
        $articles = [];
        if (File::exists($path)) {
            $json = File::get($path);
            $articles = json_decode($json, true);
        }

        return view('home', ['articles' => $articles]);
    }

    // Метод для страницы galery с отображением full_image
    public function galery($img)
    {
        return view('galery', ['image' => $img]);
    }
}
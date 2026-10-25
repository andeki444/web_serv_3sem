<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем 10 фейковых статей через фабрику
        Article::factory(10)->create();
    }
}
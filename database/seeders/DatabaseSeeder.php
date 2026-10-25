<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаем роли
        $moderatorRole = Role::firstOrCreate(['id' => 1], ['name' => 'moderator']);
        $readerRole = Role::firstOrCreate(['id' => 2], ['name' => 'reader']);

        // 2. Создаем модератора (логин: moderator@mail.ru, пароль: password)
        User::firstOrCreate(
            ['email' => 'moderator@mail.ru'],
            [
                'name' => 'Модератор',
                'password' => Hash::make('password'),
                'role_id' => $moderatorRole->id,
            ]
        );

        // 3. Создаем обычного читателя (логин: reader@mail.ru, пароль: password)
        User::firstOrCreate(
            ['email' => 'reader@mail.ru'],
            [
                'name' => 'Читатель',
                'password' => Hash::make('password'),
                'role_id' => $readerRole->id,
            ]
        );

        // 4. Наполняем статьи
        Article::factory(10)->create();
    }
}
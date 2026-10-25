<?php

namespace App\Jobs;

use App\Mail\ArticleCreatedMail;
use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VeryLongJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Article $article;

    // Передаем экземпляр созданной статьи в конструктор задания
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    // Выполнение отправки письма при обработке очереди
    public function handle(): void
    {
        // Укажи здесь свою почту модератора (ту же, что настраивал в 8 лабе)
        $moderatorEmail = 'hueputolo228@mail.ru';

        Mail::to($moderatorEmail)->send(new ArticleCreatedMail($this->article));
    }
}
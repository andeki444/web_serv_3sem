<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewArticleNotification extends Notification
{
    use Queueable;

    public Article $article;

    // 4. Передаем в конструктор объект созданной статьи
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    // 5. Настраиваем канал доставки — database
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // 6-7. Метод toDatabase с возвратом массива данных
    public function toDatabase(object $notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'name' => $this->article->name,
            'message' => 'Опубликована новая статья: ' . $this->article->name,
        ];
    }
}
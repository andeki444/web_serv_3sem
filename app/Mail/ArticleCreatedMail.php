<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ArticleCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    // Экземпляр добавленной статьи
    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    // Метод build для сборки сообщения по заданию
    public function build()
    {
        return $this->subject('Оповещение: добавлена новая статья — ' . $this->article->name)
                    ->view('mail.article-created');
    }
}
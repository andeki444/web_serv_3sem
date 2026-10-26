<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyStatsMail extends Mailable
{
    use Queueable, SerializesModels;

    public int $viewsCount;
    public int $commentsCount;

    public function __construct(int $viewsCount, int $commentsCount)
    {
        $this->viewsCount = $viewsCount;
        $this->commentsCount = $commentsCount;
    }

    public function build()
    {
        return $this->subject('Статистика использования сайта за день')
                    ->view('mail.daily-stats');
    }
}
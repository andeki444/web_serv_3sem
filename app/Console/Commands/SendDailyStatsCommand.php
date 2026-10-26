<?php

namespace App\Console\Commands;

use App\Mail\DailyStatsMail;
use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyStatsCommand extends Command
{
    // Сигнатура команды для консоли
    protected $signature = 'stats:send';

    protected $description = 'Отправка модератору статистики просмотров и комментариев за день';

    public function handle(): void
    {
        $today = Carbon::today();

        $viewsCount = ArticleView::whereDate('created_at', $today)->count();
        $commentsCount = Comment::whereDate('created_at', $today)->count();

        // Указываем СВОЮ реальную почту напрямую:
        $moderatorEmail = 'hueputolo228@mail.ru';

        Mail::to($moderatorEmail)->send(new DailyStatsMail($viewsCount, $commentsCount));

        $this->info("Статистика успешно отправлена на {$moderatorEmail}! (Просмотров: {$viewsCount}, Комментариев: {$commentsCount})");
    }
}
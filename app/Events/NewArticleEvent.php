<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewArticleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Article $article)
    {
    }

    public function broadcastOn(): array
    {
        return [new Channel('articles')];
    }

    public function broadcastWith(): array
    {
        return [
            'article' => [
                'id' => $this->article->id,
                'name' => $this->article->name,
            ],
        ];
    }
}

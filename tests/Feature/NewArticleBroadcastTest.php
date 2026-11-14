<?php

namespace Tests\Feature;

use App\Events\NewArticleEvent;
use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NewArticleBroadcastTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_an_article_dispatches_a_public_broadcast(): void
    {
        Event::fake([NewArticleEvent::class]);
        Queue::fake();
        $role = Role::create(['name' => 'moderator']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $this->actingAs($user)->post(route('articles.store'), [
            'date' => '2026-11-14',
            'name' => 'Новая статья',
            'short_desc' => 'Краткое описание',
            'desc' => 'Достаточно длинный текст новой статьи.',
        ])->assertRedirect(route('articles.index'));

        $article = Article::firstOrFail();
        Event::assertDispatched(NewArticleEvent::class, function (NewArticleEvent $event) use ($article) {
            return $event->broadcastOn() == [new Channel('articles')]
                && $event->broadcastWith() === [
                    'article' => ['id' => $article->id, 'name' => 'Новая статья'],
                ];
        });
    }
}

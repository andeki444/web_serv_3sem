<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <style>
        body { font-family: sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh; background-color: #fafafa; }
        header { background: #333; color: #fff; padding: 12px 20px; }
        nav a { color: #fff; text-decoration: none; margin-right: 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        main { flex: 1; padding: 20px; max-width: 900px; margin: 0 auto; width: 100%; box-sizing: border-box; }
        footer { background: #eee; padding: 15px 20px; text-align: center; border-top: 1px solid #ccc; }

        /* Выпадающее меню уведомлений */
        .notif-wrapper { position: relative; display: inline-block; margin-right: 15px; }
        .notif-btn { background: #444; color: #fff; border: 1px solid #666; border-radius: 4px; padding: 6px 12px; cursor: pointer; font-size: 14px; }
        .notif-badge { background: #dc3545; color: #fff; border-radius: 10px; padding: 2px 7px; font-size: 12px; font-weight: bold; margin-left: 5px; }
        .notif-dropdown { display: none; position: absolute; right: 0; top: 100%; background: #fff; color: #333; min-width: 280px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); border-radius: 6px; z-index: 1000; margin-top: 5px; border: 1px solid #ddd; }
        .notif-wrapper:hover .notif-dropdown { display: block; }
        .notif-item { display: block; padding: 10px 14px; border-bottom: 1px solid #eee; text-decoration: none; color: #007bff; font-size: 13px; line-height: 1.4; }
        .notif-item:hover { background-color: #f8f9fa; }
        .notif-empty { padding: 12px 14px; font-size: 13px; color: #777; text-align: center; }
    </style>
</head>
<body>

    <header>
        <nav style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center;">
                <a href="/">Главная</a>
                <a href="/articles">Статьи</a>

                @can('create', App\Models\Article::class)
                    <a href="{{ route('articles.create') }}" style="color: #28a745;">+ Создать новость</a>
                    <a href="{{ route('comments.moderation') }}" style="color: #ffc107;">Модерация комментариев</a>
                @endcan

                <a href="/about">О нас</a>
                <a href="/contact">Контакты</a>
            </div>

            <div style="display: flex; align-items: center;">
                @auth
                    {{-- 9. Выпадающий список с непрочитанными уведомлениями --}}
                    @php
                        $unreadNotifications = Auth::user()->unreadNotifications;
                    @endphp
                    <div class="notif-wrapper">
                        <button type="button" class="notif-btn">
                            Уведомления
                            <span class="notif-badge">{{ $unreadNotifications->count() }}</span>
                        </button>
                        <div class="notif-dropdown">
                            @forelse($unreadNotifications as $notif)
                                {{-- 10. Переход по имени статьи и отметка о прочтении --}}
                                <a href="{{ route('notifications.read', $notif->id) }}" class="notif-item">
                                    <strong>{{ $notif->data['name'] ?? 'Новая статья' }}</strong>
                                    <div style="color: #666; font-size: 11px;">{{ $notif->created_at->diffForHumans() }}</div>
                                </a>
                            @empty
                                <div class="notif-empty">Новых уведомлений нет</div>
                            @endforelse
                        </div>
                    </div>

                    <span style="margin-right: 15px;">
                        {{ Auth::user()->name }} 
                        <small style="color: #aaa;">({{ Auth::user()->role->name ?? 'читатель' }})</small>
                    </span>

                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold; text-decoration: underline;">
                            Выйти
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Войти</a>
                    <a href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Киселёв Денис Александрович | Группа 251-3210</p>
    </footer>

</body>
</html>
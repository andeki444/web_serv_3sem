<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Мой сайт')</title>
    <style>
        body { font-family: sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh; }
        header { background: #333; color: #fff; padding: 15px 20px; }
        nav a { color: #fff; text-decoration: none; margin-right: 15px; font-weight: bold; }
        nav a:hover { text-decoration: underline; }
        main { flex: 1; padding: 20px; max-width: 900px; margin: 0 auto; width: 100%; box-sizing: border-box; }
        footer { background: #eee; padding: 15px 20px; text-align: center; border-top: 1px solid #ccc; }
    </style>
</head>
<body>

    <header>
        <nav style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
            <div>
                <a href="/" style="margin-right: 15px;">Главная</a>
                <a href="/articles" style="margin-right: 15px;">Статьи</a>

                {{-- Пункт меню виден ТОЛЬКО модератору --}}
                @can('create', App\Models\Article::class)
                    <a href="{{ route('articles.create') }}" style="margin-right: 15px; color: #28a745; font-weight: bold;">
                        + Создать новость
                    </a>
                @endcan

                <a href="/about" style="margin-right: 15px;">О нас</a>
                <a href="/contact" style="margin-right: 15px;">Контакты</a>
            </div>

            <div>
                @auth
                    <span style="margin-right: 15px;">
                        {{ Auth::user()->name }} 
                        <small style="color: #666;">({{ Auth::user()->role->name ?? 'читатель' }})</small>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; font-weight: bold; text-decoration: underline;">
                            Выйти
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="margin-right: 15px;">Войти</a>
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
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
        <nav>
            <a href="/">Главная</a>
            <a href="/about">О нас</a>
            <a href="/contact">Контакты</a>
            <a href="/signin">Регистрация</a>
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
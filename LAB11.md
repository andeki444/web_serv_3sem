# Лабораторная работа 11: уведомления о статьях

После создания статьи событие `NewArticleEvent` отправляется через публичный канал
`articles`. Компонент Vue в общем шаблоне показывает посетителям ссылку на статью.

Для включения доставки заполните в локальном `.env` значения `PUSHER_APP_ID`,
`PUSHER_APP_KEY`, `PUSHER_APP_SECRET`, `PUSHER_APP_CLUSTER=eu`,
`VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"`,
`VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"` и
`BROADCAST_CONNECTION=pusher`. Ключи не добавляйте в Git.

Затем выполните `php artisan config:clear`, `npm run build` и запустите
`php artisan queue:work` отдельным процессом. Откройте сайт в одном окне,
создайте статью от лица модератора в другом — сообщение появится в первом окне.

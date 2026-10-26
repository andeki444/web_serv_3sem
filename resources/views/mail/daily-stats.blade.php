<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика сайта</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div style="max-width: 550px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 6px; border: 1px solid #ddd;">
        <h2 style="color: #333; margin-top: 0;">Ежедневный отчет модератору</h2>
        <p style="font-size: 15px; color: #555;">Статистика активности пользователей за сегодня:</p>

        <ul style="font-size: 15px; line-height: 1.8; color: #333;">
            <li><strong>Количество просмотров статей:</strong> {{ $viewsCount }}</li>
            <li><strong>Количество новых комментариев:</strong> {{ $commentsCount }}</li>
        </ul>

        <p style="font-size: 13px; color: #888; margin-top: 25px;">
            Отчет сгенерирован автоматически планировщиком задач.
        </p>
    </div>
</body>
</html>
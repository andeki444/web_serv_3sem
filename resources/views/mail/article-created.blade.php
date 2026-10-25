<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новая публикация на сайте</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 25px; border-radius: 8px; border: 1px solid #e0e0e0;">
        <h2 style="color: #28a745; margin-top: 0;">Уведомление для модератора</h2>
        <p style="font-size: 15px; color: #555;">
            На сайте была опубликована новая статья. Ниже представлены данные о публикации:
        </p>

        <div style="background-color: #f9f9f9; padding: 15px; border-left: 4px solid #007bff; margin: 20px 0;">
            <h3 style="margin: 0 0 10px 0; color: #333;">{{ $article->name }}</h3>
            <p style="margin: 5px 0; font-size: 14px; color: #777;">
                <strong>Дата публикации:</strong> {{ $article->date }}
            </p>
            <p style="margin: 10px 0 0 0; font-size: 14px; color: #444; line-height: 1.5;">
                <strong>Краткое описание:</strong><br>
                {{ $article->short_desc }}
            </p>
        </div>

        <div style="margin-top: 25px; text-align: center;">
            <a href="{{ route('articles.show', $article->id) }}" 
               style="background-color: #007bff; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">
                Перейти к просмотру статьи
            </a>
        </div>

        <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0 15px 0;">
        <p style="font-size: 12px; color: #999; text-align: center;">
            Письмо сформировано автоматически почтовым сервисом сайта.
        </p>
    </div>
</body>
</html>
<!doctype html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Notes</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <h1 class="title">
            {{ $note->title }}
        </h1>
        <div class="content">
            <div class="content__post">
                <h3>ノートの中身</h3>
                <p>{{ $note->content }}</p>    
            </div>
        </div>
        <div class="category_id">
            <div class="category_id__post">
                <h3>カテゴリー</h3>
                <p>{{ $note->category_id }}</p>    
            </div>
        </div>
        <div class="footer">
            <a href="/">戻る</a>
        </div>
    </body>
</html>
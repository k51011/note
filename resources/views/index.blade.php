<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Note</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <h1>Note Name</h1>
        <div class='notes'>
            @foreach ($notes as $note)
                <div class='note'>
                    <h2 class='title'><a href="/notes/{{ $note->id }}">タイトル：{{ $note->title }}</a></h2>
                    <p class='content'>内容：{{ $note->content }}</p>
                    <p class='category'>カテゴリーID：{{ $note->category_id }}</p>
                    
                </div>
            @endforeach
        </div>
        [<a href='/notes/create'>create</a>]
    </body>
</html>
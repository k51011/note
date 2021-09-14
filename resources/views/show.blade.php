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
        <p class="edit">[<a href="/notes/{{ $note->id }}/edit">編集</a>]</p>
        <form action="/notes/{{ $note->id }}" id="form_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <input type="submit" style="display:none">
            <p class='delete'>[<span onclick="return deleteNote(this);">削除</span>]</p>
        </form>
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
        <script>
            function deleteNote(e) {
                'use strict';
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById('form_delete').submit();
                }
            }
        </script>
    </body>
</html>
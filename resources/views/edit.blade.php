<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Note</title>
    </head>
    <body>
        <h1 class="title">編集画面</h1>
        <div class="content">
            <form action="/notes/{{ $note->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class='content__title'>
                    <h2>タイトル</h2>
                    <input type='text' name='note[title]' value="{{ $note->title }}">
                </div>
                <div class='content__content'>
                    <h2>本文</h2>
                    <input type='text' name='note[content]' value="{{ $note->content }}">
                </div>
                 <div class="content__category_id">
                    <h2>Category_id</h2>
                    <input type='text' name='note[category_id]' value="{{ $note->category_id }}">
                </div>
                <input type="submit" value="保存">
            </form>
            <div class='back'>[<a href='/notes/{{ $note->id }}'>戻る</a>]</div>
        </div>
    </body>
</html>
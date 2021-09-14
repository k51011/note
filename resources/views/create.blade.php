<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Note</title>
    </head>
    <body>
        <h1>Note Name</h1>
        <form action="/notes" method="POST">
            @csrf
            <div class="title">
                <h2>Title</h2>
                <input type="text" name="note[title]" placeholder="タイトル"/>
            </div>
            <div class="content">
                <h2>Content</h2>
                <textarea name="note[content]" placeholder="内容"></textarea>
            </div>
            <div class="category_id">
                <h2>Category_id</h2>
                <textarea name="note[category_id]" placeholder="1：テスト"></textarea>
            </div>
            <input type="submit" value="保存"/>
        </form>
        <div class="back">[<a href="/">back</a>]</div>
    </body>
</html>
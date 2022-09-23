<!DOCTYPE html>
@extends('layouts.app')

@section('content')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>イラスト投稿サイト</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

       
    </head>
    <body>
        <h1>イラスト投稿サイト</h1>
        <form action="/works" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="title">
                <h2>作品名</h2>
                <input type="text" name="work[title]" placeholder="タイトル" value="{{ old('work.title') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('work.title') }}</p>
            </div>
            
            <div class="image">
                <input type="file" name="image">
            </div>
            <div class="tags">
                <input id="tags" type="text" name="tags" placeholder="＃(半角)タグを入力" value="{{old('tags')}}">
            </div>
            <div class="body">
                <h2>コメント</h2>
                <textarea name="work[body]" placeholder="コメント"></textarea>
                <p class="body__error" style="color:red">{{ $errors->first('work.body') }}</p>
            </div>
            
            <input type="submit" value="投稿"/>
            @if(\Auth::user()->age >= 18)
            <div class="age">
                <p>成人向けコンテンツとして投稿する</p>
               <label>
                   
                   <input type="radio" name="work[age]" value="1" required>はい
               </label>
               <label>
                   
                   <input type="radio" name="work[age]" value="0" required>いいえ
               </label>
            </div>
            <p class="age_error" style="color:red">{{ $errors->first('work.age') }}</p>
            @else
            <input type="hidden" name="work[age]" value="0">
            @endif
            
        </form>
        <div class="戻る">[<a href="/">戻る</a>]</div>
    </body>
</html>
@endsection
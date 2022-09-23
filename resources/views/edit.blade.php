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
        <form action="/works/{{ $work->id }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            @method('PUT')
            <div class="title">
                <h2>作品名</h2>
                <input type="text" name="work[title]" placeholder="タイトル"　value="{{ $work->title }}"/>
                
            <!--<style>-->
            <!--    img{-->
            <!--        max-width: 100%;-->
            <!--        height: auto;-->
            <!--    }-->
            <!--</style>-->
            <div class="image">
                <input type="file" name="image" value="{{ $work->body }}"/>
                @if($work->image)
                <img src='{{ $work->image }}'>
                @endif
            </div>
            
           
            <div class="tags">
                <textarea id="tags" type="text" name="tags" rows="3" cols="40" style="text-align:left;">
                    @foreach($work->tags as $tag)
                    {{ trim($tag->name) }} 
                    @endforeach
                </textarea>
                    
            </div>
           
            <input type="text" id="tags" name="tags" placeholder="＃(半角)タグを入力">
            
            <div class="body">
                <h2>コメント</h2>
                <textarea name="work[body]" placeholder="コメント">{{ $work->body }}</textarea>
                
            </div>
            <div class="age">
                <p>成人向けコンテンツとして投稿する</p>
               <label>
                   
                   <input type="radio" name="age" value="yes" required>はい
               </label>
               <label>
                   
                   <input type="radio" name="age" value="no">いいえ
               </label>
            </div>
            <input type="submit" value="更新"/>
        </form>
        <div class="戻る">[<a href="/works/{{ $work->id }}">戻る</a>]</div>
    </body>
</html>
@endsection
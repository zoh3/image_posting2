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
        <tr>
            <td>
                <button class="btn btn-info"><a href="/works/{{ $work->id }}/edit">編集</a></btn>
            </td>
            <td>
                <form action="/works/{{ $work->id }}" id="form_delete" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <input type="submit" style="display:none">
                    <button type="delete" class="btn btn-danger"><span onclick="return deletePost(this);">削除</span></button>
                </form>
            </td>
        </tr>
        
        <div class="work">
            <h2 class="title">{{ $work->title }}</h2>
            
            @if ($work->image)
            <style>
                img{
                    max-width:100%;
                    height:auto;
                    }
            </style>
            <div class="image">
            <img src='{{ $work->image }}'>
            </div>
            @endif
            
            <h5 class='tag'>
                @foreach($work->tags as $tag)
                    <span class="badge badge-pill badge-info">{{ $tag->name }}</span>
                @endforeach    
            </h5>
        <form action="/works/{{ $tag->id }}" id="form_delete" method="POST">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <input type="submit" style="display:none">
            <button type="submit" class="btn btn-danger">削除</button>
        </form>
        
            <p class="body">{{ $work->body }}</p>
            
            <p class="updated_at">{{ $work->updated_at }}</p>
        </div>
        <div class="back">[<a href="/">戻る</a>]</div>
        <script>
            function deletePost(e){
                'use strict';
                if(confirm('本当に削除しますか？')){
                    document.getElementById('form_delete').submit();
                }
            }
        </script>
    </body>
</html>
@endsection
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
            <h1>検索結果</h1>
            <div class="results">
                @foreach ($works as $work)
                    <div class='work'>
                        <a href='/works/{{ $work->id}}'><h2 class='作品名'>{{ $work->title }}</h2></a>
                        <p>{{ $work->body }}</p>
                        @if ($work->image)
                        <style>
                            img{
                                max-width:100%;
                                height:auto;
                            }
                        </style>
                        <div class='image'>
                        <img src='{{ $work->image }}'>
                        </div>
                        @endif
                        <h5 class='tag'>
                            @foreach($work->tags as $tag)
                                <span class="badge badge-info">{{ $tag->name }}</span>
                            @endforeach    
                        </h5>
                    </div>    
                @endforeach    
            </div>
    </body>
</html>
@endsection
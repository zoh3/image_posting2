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
        <p class='user'><a href='/users'>{{Auth::user()->name}}</a></p>
        <p class='create'>[<a href='/works/create'>新規投稿</a>]</p>
        
        <div class='search'>
            <form action="/works/search" name="tag" method="GET">
                {{ csrf_field()}}
                <div class="form-group">
                <label>タグ検索</label>
                <input type="text" name="search" class="form-control col-md-5" placeholder="検索したいタグを入力してください" value="@if (isset($search)) {{$search}} @endif">
                </div>
                <button type="submit" class="btn btn-primary col-md-5">検索</button>
            </form>
        </div>
        
    
        
        <!--もし18歳以上なら全作品を見せる-->
        @if(\Auth::user()->age >= 18)
        <div class='works'>
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
                @if ($work->users()->where('user_id', Auth::id())->exists())
                    <div class="col-md-3">
                    <form action="{{ route('unlikes', $work->id)}}" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" value="&#xf164;ブックマーク取り消す" class="fas btn btn-danger">
                    </form>
                    
                    </div>
                @else
                    <div class="like">
                    <form action="{{ route('likes', $work->id )}}" method="POST">
                        {{ csrf_field() }}
                        <input type="submit" value="&#xf164;ブックマーク" class="fas btn btn-success">
                    </form>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
            @foreach ($safe as $work)
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
                        <span class="badge badge-info">{{ $tag->name}}</span>
                    @endforeach    
                </h5>
            <!--そうでなければ$safeの作品だけを見せる-->
            </div>
            @endforeach
        @endif
        
    </body>
</html>
@endsection
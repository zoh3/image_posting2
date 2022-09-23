<!DOCTYPE html>
@extends('layouts.app')

@section('content')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>マイページ</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    

       
    </head>
    <body>
        
        <h1>マイページ</h1>
        <p class='name'>名前:{{Auth::user()->name}}</p>
        <p class='e-mail'>メールアドレス:{{$auth->email}}</p>
        <div class='image'>
            <form action="/users" method="POST" enctype="multipart/form-data">
                <input type="file" name="Mypage_image">
                @if ($auth->image)
                    <style>
                        img{
                            max-width:100%;
                            height:auto;
                            }
                    </style>
                <div class='image'>
                    <img src='{{ $auth->image }}'>
                </div>
                @endif
                <input type='submit' value='変更する'>
            </form>
        </div>    
        @if (Session::has('message'))
            <p>{{ session('messege')}}</p>
        @endif    
    </body>
</html>
@endsection
<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// ファサード
class UserController extends Controller
{
    public function index(User $user){
        $user = \Auth::user();
        return view('MyPage_index',[ 'auth' => $user]);
    }
    // store画像保存処理 storeメソッドだけ書く
}

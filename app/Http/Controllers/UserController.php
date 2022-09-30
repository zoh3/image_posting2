<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
// use Storage;
use Illuminate\Support\Facades\Storage;


// ファサード
class UserController extends Controller
{
    public function index(User $user){
        $user = \Auth::user();
        return view('MyPage_index',[ 'auth' => $user]);
    }
    // store画像保存処理 storeメソッドだけ書く
    public function store(Request $request)
    {
        $user = Auth::user();
        
        
        
        if($request->Mypage_image)
        {
            // 相対パス
            Storage::disk('s3')->delete(substr($user->image, 62));

            $image = $request->file('Mypage_image');
            $path = Storage::disk('s3')->putFile('illustration-image-bucket3', $image, 'public');
            $user->image = Storage::disk('s3')->url($path);
        }
        $user->save();
        return redirect('/users');
    }
    // public function update(WorkRequest $request, Work $work)
    // {
    //     $input = $request['work'];
    //      // 画像があったら以下の保存処理
    //     if($request->image){
    //         $image = $request->file('image');
    //         $path = Storage::disk('s3')->putFile('illustration-image-bucket3', $image, 'public');
    //         $work->image = Storage::disk('s3')->url($path);
    //     }
    //     $work->fill($input)->save();
    //     return redirect('/users');
    // }    
}

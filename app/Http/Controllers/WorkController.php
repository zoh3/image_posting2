<?php

namespace App\Http\Controllers; 


use App\Work;
use App\Tag;
use App\User;
use App\Http\Requests\WorkRequest;
// use Illuminate\Http\Request;
use Storage;

class WorkController extends Controller
{
    
    public function index(Work $work)
    {
        // 検索機能
    
        return view('index')->with(['works'=> $work->get(), 'safe' => $work->where('age', false)->get()]);
    }
    
    public function show(Work $work)
    {
        // $user = auth()->user();
        //  if($user->can('view',$work)){
        //     return view('works.show',compact('work'));
        // }else{
        //     dd('この画像は18歳未満の方は閲覧できません。');
            
        // }
        return view('show')->with(['work' => $work]);
    }
    
    public  function create()
    {
        return view('create');
    }
    
    public function store(WorkRequest $request, Work $work)
    {
        // 保存処理準備
        $input = $request['work'];
        // 画像があったら以下の保存処理、putFile
        if($request->image){
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('illustration-image-bucket3', $image, 'public');
            $work->image = Storage::disk('s3')->url($path);
        }
        
        //  #(ハッシュタグ)で始まる単語を取得。結果は、$matchに多次元配列で代入される。
        // 正規表現を理解して書く
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->tags, $match);
        // $match[0]に#(ハッシュタグ)あり、$match[1]に#なしの結果が入ってくるので、$match[1]で#なしの結果のみを使う
        $tags = [];
        foreach($match[1] as $tag){
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        }
         // 投稿に紐付けされるidを配列化
         $tags_id = [];
         foreach($tags as $tag){
            array_push($tags_id, $tag['id']);
         }
        
        // dd($tag); 
         // 先にworkテーブルに保存処理をする
        $work->fill($input)->save();
        // attachメソッドを使って中間テーブルデータを保存(こっちが後)
        $work->tags()->attach($tags_id);
        return redirect('/');
    }
    
    public function edit(Work $work)
    {
        return view('edit')->with(['work' => $work]);
    }
    
    public function update(WorkRequest $request, Work $work)
    {
        $input = $request['work'];
         // 画像があったら以下の保存処理
        if($request->image){
            $image = $request->file('image');
            $path = Storage::disk('s3')->putFile('illustration-image-bucket3', $image, 'public');
            $work->image = Storage::disk('s3')->url($path);
        }
        
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->tags, $match);
        
        $tags = [];
        foreach($match[1] as $tag){
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        }
       
         $tags_id = [];
         foreach($tags as $tag){
             array_push($tags_id, $tag['id']);
         }
        $work->fill($input)->save();
        // デタッチ(紐づけ解除)なしでsyncする
        $work->tags()->syncWithoutDetaching($tags_id);
      
        
        return redirect('works/' . $work->id);
    }
    
    public function destroy(Work $work){
        $work->delete();
        return redirect('/');
    }
    public function tag_destroy(Work $work){
        $work->tags()->detach($tags_id);
        return redirect('/works/' . $work->id);
    }
}

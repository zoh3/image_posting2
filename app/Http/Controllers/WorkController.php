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
    
    public function index(WorkRequest $request, Work $work)
    {
        // 投稿一覧をページネートで取得
        $works = Work::paginate(5);
        // 検索フォームで入力された値を取得する
        $serch = $request->input('search');
        // クエリビルダ
        $query = Work::query();
        
        // もし検索フォームにキーワードが入力されたら
        if($serch){
            // 全角スペースを半角に変換
            $spaceConversion = mb_convert_kana($search, 's');
            // 単語を半角スペースで区切り、配列にする
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($wordArraySearched as $value)
            {
                $query->where('name', 'like', '%'.$value.'%');
                
                // 上記で取得した$queryをページネートにし、変数$worksに代入
                $works = $query->paginate(5);
            }
            
        }
        
        return view('index')->with(['works'=> $work->get(), 'safe' => $work->where('age', false)->get(),'works' =>$works, 'search' => $serch]);
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
        $work->tags()->detach();
        if ($work->delete()){
            
        }
        return redirect('/works/' . $work->id);
    }
}

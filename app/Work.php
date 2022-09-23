<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'title',
        'image',
        'body',
        'age',
        ];
        
    protected $casts = [
        'age' => 'boolean',
        ];
        
    protected $guarded = ['id'];
    
    
        
    public static $rules = [
        'body' =>'required|max:500',
        'image' =>'image|file',
        ];
    
    public function tags(){
        return $this->belongsToMany('App\Tag','work_tag');
    }
    
    public function users(){
        return $this->belongsToMany('App\User','user_work');
    }
    
    protected static function boot()
    {
        parent::boot();
        
        self::saving(function($work){
            $work->user_id = \Auth::id();
        });
    }
}

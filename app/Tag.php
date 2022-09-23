<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name',
        ];
    public function works(){
        return $this->belongsToMany('App\Work','work_tag');
    }
    
    public function deleteTagById($tag){
        return $this->destroy($id);
    }
}

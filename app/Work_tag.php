<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_tag extends Model
{
    use HasFactory;
    
    protected $fillable =
    [
        'tag_id',
        'work_id',
        ];
}

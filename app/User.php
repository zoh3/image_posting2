<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'age', 'sex', 'image', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function works(){
        return $this->belongsToMany('App\Work','user_work');
    }
    
    public function userHasRole($user_age)
    {
        foreach($this->users as $user)
        {
            // userの年齢が18歳以上
            if($user_age == $user->age >= 18)
            {
                return true;
            }   
                return false;
        }
    }
// サイトは動くが年齢関係なく制限がかかってしまう
// connotにしたら見られるがcreate画面でＲ18選択しても適用されない
}

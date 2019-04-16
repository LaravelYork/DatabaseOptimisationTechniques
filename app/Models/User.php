<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\GlobalScopes\IsVerifiedScope;

use App\Models\Email;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    protected static function boot()
    {
        parent::boot();

       //static::addGlobalScope(new IsVerifiedScope);
    }

    public function scopeHasEmails($query){

        return $query->join('emails', function($query){
            $query->on('users.id','=','user_id');
        })->select('users.*');   
    
    }

    public function emails()
    {
        return $this->hasMany(Email::class);
    }

}

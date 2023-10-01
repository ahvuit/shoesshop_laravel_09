<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Eloquent implements AuthenticatableContract
{
    use HasApiTokens, HasFactory, Notifiable, Authenticatable;

    protected $connection =  'mongodb';
    protected $collection = 'user';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'userId',
        'email',
        'password',
        'utype',
        'active',
        'token'
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['userId'] = $this->id;
        unset($array['_id']);
        return $array;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

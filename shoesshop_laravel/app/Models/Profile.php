<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Profile extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;

    protected $connection =  'mongodb';
    protected $collection = 'profile';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profileId',
        'firstName',
        'lastName',
        'address',
        'phone',
        'imageUrl',
        'userId',
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['profileId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

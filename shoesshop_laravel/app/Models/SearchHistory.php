<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class SearchHistory extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;
    protected $connection =  'mongodb';
    protected $collection = 'searchHistory';

    public $timestamps = false;
    protected $fillable = [
        'searchId',
        'userId',
        'keyword',
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['searchId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

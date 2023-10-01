<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Comment extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;
    protected $connection =  'mongodb';
    protected $collection = 'comment';

    public $timestamps = false;
    protected $fillable = [
        'cmtId',
        'productId',
        'userId',
        'content',
        'image',
        'createdDate',

    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['cmtId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

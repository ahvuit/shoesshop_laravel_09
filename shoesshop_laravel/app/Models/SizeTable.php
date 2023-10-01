<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class SizeTable extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;

    protected $connection =  'mongodb';
    protected $collection = 'sizeTable';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sizeTableId',
        's38',
        's39',
        's40',
        's41',
        's42',
        's43',
        's44',
        's45',
        's46',
        's47',
        's48',
        'productId'
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['sizeTableId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class OrderDetails extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;
    protected $connection =  'mongodb';
    protected $collection = 'orderDetails';

    public $timestamps = false;
    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'size',
        'price',
        'total'
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['id'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Order extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;
    protected $connection =  'mongodb';
    protected $collection = 'order';

    public $timestamps = false;
    protected $fillable = [
        'orderId',
        'firstName',
        'lastName',
        'userId',
        'statusId',
        'phone',
        'email',
        'address',
        'note',
        'total',
        'payment',
        'momo',
        'createdDate',
        'bookingDate',
        'deliveryDate'
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['orderId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

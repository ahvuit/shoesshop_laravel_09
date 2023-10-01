<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Product extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;
    protected $connection =  'mongodb';
    protected $collection = 'product';

    public $timestamps = false;
    protected $fillable = [
        'productId',
        'name',
        'brandId',
        'categoryId',
        'price',
        'productNew',
        'purchase',
        'stock',
        'active',
        'image',
        'rate',
        'description',
        'createdDate',
        'dateUpdated',
        'updateBy',
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['productId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

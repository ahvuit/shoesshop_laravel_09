<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Brand extends Eloquent implements AuthenticatableContract
{
    use HasFactory, Notifiable, Authenticatable;

    protected $connection =  'mongodb';
    protected $collection = 'brand';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'brandId',
        'brandName',
        'information',
        'logo',
    ];

    public function toArray()
    {
        $array = parent::toArray();
        $array['brandId'] = $this->id;
        unset($array['_id']);
        return $array;
    }
}

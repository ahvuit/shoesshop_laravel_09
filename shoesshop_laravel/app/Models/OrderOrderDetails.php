<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Summary of OrderOrderDetails
 */
class OrderOrderDetails
{
    use Notifiable, Authenticatable;
    public $orderModel;
    public $listOrderDetails;

    protected $fillable = [
        'orderModel',
        'listOrderDetails',
    ];

    public function __construct($orderModel, $listOrderDetails) {
        $this->orderModel = $orderModel;
        $this->listOrderDetails = $listOrderDetails;
    }
}

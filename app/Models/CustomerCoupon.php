<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCoupon extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "customer_coupon";
    protected $primaryKey = "id_customer_coupon";
    protected $fillable = [
        "id_customer",
        "id_coupon",
    ];
}

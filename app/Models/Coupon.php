<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "coupon";
    protected $primaryKey = "id_coupon";
    protected $fillable = [
        "name_coupon",
        "code_coupon",
        "quantity_coupon",
        "type_coupon",
        "discount_coupon",
        "expiration_time",
        "is_buy",
        "is_price",
    ];
}

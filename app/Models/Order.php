<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "order";
    protected $primaryKey = "id_order";
    protected $fillable =
    [
        "id_customer","code_order", "name_order",'phone_order','address_order',"email_order","subtotal_order", "fee_ship", "fee_discount", "total_order", "status_order", "date_updated"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "detail_orders";
    protected $primaryKey = "id_detail";
    protected $fillable = [
        "id_order",
        "code_order",
        'image_product',
        'name_product',
        "quantity_product",
        "price_product",
        "note_product",
    ];
}

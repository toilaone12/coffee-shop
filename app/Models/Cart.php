<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_cart';
    protected $table = 'cart';
    protected $fillable = ['image_product','name_product','quantity_product','price_product','note_product'];
    public $timestamps = true;
}

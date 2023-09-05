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
    protected $fillable = ["code_order",'name_order',"total_order","status_order"];
}

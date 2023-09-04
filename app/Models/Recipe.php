<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "recipe";
    protected $primaryKey = "id_recipe";
    protected $fillable = ["id_product","component_recipe"];
}

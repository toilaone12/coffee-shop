<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "ingredients";
    protected $primaryKey = "id_ingredient";
    protected $fillable = ["id_unit","name_ingredient","quantity_ingredient"];
}

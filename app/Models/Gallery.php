<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "gallery";
    protected $primaryKey = "id_gallery";
    protected $fillable = ["id_product","image_gallery"];
}

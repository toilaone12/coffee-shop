<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_slide';
    protected $table = 'slide';
    protected $fillable = ['image_slide','name_slide','slug_slide'];
    public $timestamps = true;
}

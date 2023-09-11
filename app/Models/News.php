<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "news";
    protected $primaryKey = "id_new";
    protected $fillable = ["image_new","title_new",'subtitle_new',"content_new","view_new"];
}

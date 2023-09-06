<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "review";
    protected $primaryKey = "id_review";
    protected $fillable = ["id_product","name_review","content_review",'rating_review','id_reply'];
}

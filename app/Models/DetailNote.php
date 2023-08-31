<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailNote extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "detail_notes";
    protected $primaryKey = "id_detail";
    protected $fillable = [
        "id_note",
        "id_unit",
        "code_note",
        'name_ingredient',
        "quantity_ingredient",
        "price_ingredient"
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "notes";
    protected $primaryKey = "id_note";
    protected $fillable = ["id_supplier","code_note",'name_note',"quantity_note","status_note"];
}

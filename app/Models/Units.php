<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_unit';
    protected $table = 'units';
    protected $fillable = ['fullname_unit','abbreviation_unit'];
    public $timestamps = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_fee';
    protected $table = 'fee';
    protected $fillable = ['radius_fee','weather_condition','fee'];
    public $timestamps = true;
}

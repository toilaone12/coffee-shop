<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_statistic';
    protected $table = 'statistic';
    protected $fillable = ['quantity_statistic','price_statistic','date_statistic'];
    public $timestamps = true;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_supplier';
    protected $table = 'supplier';
    protected $fillable = ['name_supplier','phone_supplier','address_supplier'];
    public $timestamps = true;
}

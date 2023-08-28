<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "customer";
    protected $primaryKey = "id_customer";
    protected $fillable = [
        "image_customer",
        "name_customer",
        "gentle_customer",
        "email_customer",
        "phone_customer",
        "password_customer",
        "is_vip",
    ];
}

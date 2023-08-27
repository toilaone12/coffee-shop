<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_account';
    protected $table = 'account';
    protected $fillable = ['fullname_account','username_account','email_account','password_account','otp_account','id_role','is_online'];
    public $timestamps = true;
}

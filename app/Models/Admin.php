<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_admin';
    protected $table = 'admin';
    protected $fillable = ['fullname_admin','email_admin','password_admin','id_role','is_online'];
    public $timestamps = true;
}

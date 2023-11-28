<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $table = "notification";
    protected $primaryKey = "id_notification";
    protected $fillable = ["id_account","id_customer",'content',"link","is_read"];
}

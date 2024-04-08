<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Borrowtotal extends Model
{
    use SoftDeletes;
    use HasFactory;
    Protected $fillable = ['name','total','donetotal','admin_id'];
}

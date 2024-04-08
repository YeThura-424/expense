<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Total extends Model
{
    use SoftDeletes;
    use HasFactory;
    Protected $fillable = ['date','total','admin_id'];

}

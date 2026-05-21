<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'area_masters';

    protected $fillable = ['area_name', 'status'];
}

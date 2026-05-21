<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesPerson extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales_persons';

    protected $fillable = ['name', 'email', 'phone', 'city', 'status'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}

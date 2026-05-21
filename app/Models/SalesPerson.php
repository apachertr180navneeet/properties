<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesPerson extends Model
{
    use HasFactory;

    protected $table = 'sales_persons';

    protected $fillable = ['name', 'email', 'phone'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}

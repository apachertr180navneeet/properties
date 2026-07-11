<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'property_name',
        'remark',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

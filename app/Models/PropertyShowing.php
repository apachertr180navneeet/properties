<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyShowing extends Model
{
    protected $fillable = [
        'customer_id',
        'property_id',
        'sales_person_id',
        'show_date',
    ];

    protected $casts = [
        'show_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function salesPerson()
    {
        return $this->belongsTo(SalesPerson::class);
    }
}

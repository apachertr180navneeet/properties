<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_person_id',
        'title',
        'property_type',
        'property_category',

        'price',
        'stamp_duty',
        'location',
        'city',
        'state',
        'address',
        'pin_code',
        'plot_number',
        'area_size',
        'area_unit',
        'corner_plot',
        'property_photo',
        'registry_document',
    ];

    protected $casts = [
        'corner_plot' => 'boolean',
        'price' => 'decimal:2',
        'stamp_duty' => 'decimal:2',
        'area_size' => 'decimal:2',
    ];

    public function salesPerson()
    {
        return $this->belongsTo(SalesPerson::class);
    }
}

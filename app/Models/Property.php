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
        'owner_name',
        'owner_phone',
        'property_type',
        'property_category',

        'price',
        'sq_yard_rate',
        'stamp_duty',
        'location',
        'city',
        'state',
        'address',
        'pin_code',
        'plot_number',
        'area_size',
        'area_unit',
        'length',
        'width',
        'size_separator',
        'corner_plot',
        'facing',
        'remarks',
        'via',
        'registry_owner',
        'setup_type',
        'add_on_date',
        'build_type',
        'property_condition',
        'construction_type',
        'property_age',
        'property_photo',
        'registry_document',
    ];

    protected $casts = [
        'corner_plot' => 'string',
        'price' => 'decimal:2',
        'sq_yard_rate' => 'decimal:2',
        'stamp_duty' => 'decimal:2',
        'area_size' => 'decimal:2',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'add_on_date' => 'date',
    ];

    public function salesPerson()
    {
        return $this->belongsTo(SalesPerson::class);
    }

    public function salesPersons()
    {
        return $this->belongsToMany(SalesPerson::class, 'property_sales_person');
    }

    public function showings()
    {
        return $this->hasMany(PropertyShowing::class);
    }
}

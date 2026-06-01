<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sales_person_id',
        'name',
        'email',
        'phone',
        'city',
        'base_requirement',
        'visit_date',
        'whatsapp_count',
        'messaging',
        'status',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function salesPerson()
    {
        return $this->belongsTo(SalesPerson::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class)->withTimestamps();
    }

    public function showings()
    {
        return $this->hasMany(PropertyShowing::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['sales_person_id', 'title', 'price', 'status', 'location'];

    public function salesPerson()
    {
        return $this->belongsTo(SalesPerson::class);
    }
}

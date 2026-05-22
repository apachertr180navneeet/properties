<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'message_templates';

    protected $fillable = [
        'template_name',
        'days_to_send',
        'message_content',
        'image',
        'status',
    ];
}

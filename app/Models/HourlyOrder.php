<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HourlyOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'Period',
        'number_of_hours',
        'nationality',
        'city',
        'company_id',
        'categorie_id',
        'date',
        'time',
        'system',
        'user_id',
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_of_months',
        'nationality',
        'city',
        'company_id',
        'categorie_id',
        'date',
        'time',
        'user_id',
        'status'
    ];
}

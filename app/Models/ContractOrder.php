<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'status',
        'address'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(company::class, 'company_id');
    }
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(categorie::class, 'categorie_id');
    }

}

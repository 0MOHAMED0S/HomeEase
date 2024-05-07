<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

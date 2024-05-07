<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'path',
        'nationality',
        'categorie_id',
        'status',
        'user_id',
        'tybe',
        'numbers'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    public function ConOrder(): HasOne
    {
        return $this->hasOne(ContractOrder::class);
    }
    public function HouOrder(): HasOne
    {
        return $this->hasOne(HourlyOrder::class);
    }
}

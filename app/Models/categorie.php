<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'path',
        'name'
    ];
    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
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

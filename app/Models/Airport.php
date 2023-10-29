<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airport extends Model
{
    use SoftDeletes;

    protected $fillable = ['iata_code', 'latitude', 'longitude', 'terms_conditions'];

    public function translations()
    {
        return $this->hasMany(AirportTranslation::class);
    }
}

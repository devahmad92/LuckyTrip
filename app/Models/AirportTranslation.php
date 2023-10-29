<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AirportTranslation extends Model
{
    protected $fillable = ['airport_id', 'language_code', 'name', 'description'];

    public function airport()
    {
        return $this->belongsTo(Airport::class);
    }
}

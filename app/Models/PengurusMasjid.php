<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusMasjid extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function masjid()
    {
        return $this->hasOne(Masjid::class);
    }
}

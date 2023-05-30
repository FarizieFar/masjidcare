<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pengurusMasjid()
    {
        return $this->hasOne(PengurusMasjid::class);
    }
}

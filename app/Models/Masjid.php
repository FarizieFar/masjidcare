<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function pencairan(){
        return $this->hasOne(Pencairan::class);
    }

    public function donasi(){
        return $this->hasMany(Donasi::class);
    }
}

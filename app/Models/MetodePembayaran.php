<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'metode_pembayarans';

    public function donasi(){
        return $this->hasMany(Donasi::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'donasis';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function masjid(){
        return $this->belongsTo(Masjid::class);
    }

    public function metode(){
        return $this->belongsTo(MetodePembayaran::class);
    }
}

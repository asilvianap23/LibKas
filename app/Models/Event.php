<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal_event',
        'kuitansi_template', 
        
    ];
    // Event.php
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'event_paket');
    }
}

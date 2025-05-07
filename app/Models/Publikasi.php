<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    use HasFactory;

    protected $fillable = ['anggota_id', 'judul', 'tahun', 'keterangan', 'naskah'];

    // Relasi ke model Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

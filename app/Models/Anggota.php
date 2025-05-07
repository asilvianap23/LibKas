<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama',
        'jabatan',
        'pendidikan',
        'wa',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function publikasis()
{
    return $this->hasMany(Publikasi::class);
}
}

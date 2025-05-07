<?php
// app/Models/Paket.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = ['nama_paket', 'nominal'];

    // Relasi ke Event
    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_paket');
    }
}

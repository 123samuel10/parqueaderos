<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
     protected $table = 'reservas';
    protected $fillable = ['parqueadero_id', 'nombre_usuario', 'hora_inicio', 'hora_fin'];
    public $timestamps = false;

    public function parqueadero()
    {
        return $this->belongsTo(Parqueadero::class, 'parqueadero_id');
    }
}

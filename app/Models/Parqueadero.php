<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parqueadero extends Model
{
  use HasFactory;

    protected $fillable = [
        'nombre',
        'ubicacion',
        'espacios_disponibles',
        'precio_por_hora',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}

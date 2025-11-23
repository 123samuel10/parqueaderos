<?php

namespace App\Services;

use App\Models\Parqueadero;

class ParqueaderoService
{
    /**
     * Verifica si un parqueadero tiene espacios disponibles
     */
    public function tieneEspaciosDisponibles(Parqueadero $parqueadero): bool
    {
        return $parqueadero->espacios_disponibles > 0;
    }

    /**
     * Calcula el costo total de una reserva
     */
    public function calcularCostoTotal(Parqueadero $parqueadero, int $horas): float
    {
        return $parqueadero->precio_por_hora * $horas;
    }

    /**
     * Ocupa un espacio en el parqueadero
     */
    public function ocuparEspacio(Parqueadero $parqueadero): void
    {
        $parqueadero->espacios_disponibles -= 1;
    }
}

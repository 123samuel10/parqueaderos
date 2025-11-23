<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\ParqueaderoService;
use App\Models\Parqueadero;

class ParqueaderoDisponibilidadTest extends TestCase
{
    /**
     * Test: Un parqueadero con espacios disponibles debe retornar true
     */
    public function test_parqueadero_tiene_espacios_disponibles()
    {
        // Arrange
        $parqueadero = new Parqueadero([
            'nombre' => 'Parqueadero Centro',
            'ubicacion' => 'Calle 50 #45-67',
            'espacios_disponibles' => 10,
            'precio_por_hora' => 5000
        ]);

        $service = new ParqueaderoService();

        // Act
        $resultado = $service->tieneEspaciosDisponibles($parqueadero);

        // Assert
        $this->assertTrue($resultado);
    }

    /**
     * Test: Un parqueadero sin espacios disponibles debe retornar false
     */
    public function test_parqueadero_sin_espacios_disponibles()
    {
        // Arrange
        $parqueadero = new Parqueadero([
            'nombre' => 'Parqueadero Sur',
            'ubicacion' => 'Carrera 30 #10-20',
            'espacios_disponibles' => 0,
            'precio_por_hora' => 3000
        ]);

        $service = new ParqueaderoService();

        // Act
        $resultado = $service->tieneEspaciosDisponibles($parqueadero);

        // Assert
        $this->assertFalse($resultado);
    }

    /**
     * Test: Calcular el costo total de una reserva
     */
    public function test_calcular_costo_total_reserva()
    {
        // Arrange
        $parqueadero = new Parqueadero([
            'nombre' => 'Parqueadero Norte',
            'ubicacion' => 'Avenida 80 #100-50',
            'espacios_disponibles' => 5,
            'precio_por_hora' => 4000
        ]);

        $service = new ParqueaderoService();
        $horas = 3;

        // Act
        $costo = $service->calcularCostoTotal($parqueadero, $horas);

        // Assert
        $this->assertEquals(12000, $costo);
    }

    /**
     * Test: Reducir espacios disponibles al hacer una reserva
     */
    public function test_reducir_espacios_al_reservar()
    {
        // Arrange
        $parqueadero = new Parqueadero([
            'nombre' => 'Parqueadero Este',
            'ubicacion' => 'Calle 72 #10-34',
            'espacios_disponibles' => 8,
            'precio_por_hora' => 6000
        ]);

        $service = new ParqueaderoService();

        // Act
        $espaciosAnteriores = $parqueadero->espacios_disponibles;
        $service->ocuparEspacio($parqueadero);

        // Assert
        $this->assertEquals($espaciosAnteriores - 1, $parqueadero->espacios_disponibles);
    }
}

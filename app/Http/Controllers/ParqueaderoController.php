<?php

namespace App\Http\Controllers;

use App\Models\Parqueadero;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class ParqueaderoController extends Controller
{  public function inicio()
    {
        $usuario = Session::get('usuario');

        if (!$usuario) {
            $parqueaderos = Parqueadero::all();
            return view('parqueaderos.index', compact('parqueaderos', 'usuario'));
        }

        if ($usuario->email === 'admin@gmail.com') {
            $parqueaderos = Parqueadero::with('reservas')->get();
            return view('parqueaderos.index', compact('parqueaderos', 'usuario'));
        }

        $reservas = Reserva::where('nombre_usuario', $usuario->nombre)
            ->with('parqueadero')
            ->get();

        return view('parqueaderos.mis_reservas', compact('usuario', 'reservas'));
    }


    public function create()
    {
        $usuario = Session::get('usuario');

        if (!$usuario || $usuario->email !== 'admin@gmail.com') {
            return redirect('/')->with('error', 'Solo el administrador puede registrar parqueaderos.');
        }

        return view('parqueaderos.crear');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'espacios_disponibles' => 'required|integer|min:1',
            'precio_por_hora' => 'required|numeric|min:0',
        ]);

        Parqueadero::create($request->all());

        return redirect('/')->with('success', 'Parqueadero registrado correctamente');
    }
public function reservar($id, Request $request)
{
    $parqueadero = Parqueadero::findOrFail($id);

    // Si no viene fecha → mostramos por defecto el día de hoy
    $fecha = $request->fecha ?? now()->toDateString();

    $reservas = Reserva::where('parqueadero_id', $id)
        ->whereDate('hora_inicio', $fecha)
        ->get();

    return view('parqueaderos.reservar', compact('parqueadero', 'reservas', 'fecha'));
}


public function guardarReserva(Request $request)
{
    $request->validate([
        'parqueadero_id' => 'required|integer',
        'hora_inicio' => 'required|date',
        'hora_fin' => 'required|date|after:hora_inicio',
    ]);

    $usuario = Session::get('usuario')->nombre;
    $parqueadero = Parqueadero::findOrFail($request->parqueadero_id);

    // Verificar si hay espacios disponibles
    if ($parqueadero->espacios_disponibles <= 0) {
        return redirect()->back()->with('error', 'No hay espacios disponibles en este parqueadero.');
    }

    // Verificar que no haya conflicto de horarios
    $existeReserva = Reserva::where('parqueadero_id', $request->parqueadero_id)
        ->where(function ($query) use ($request) {
            $query->where('hora_inicio', '<', $request->hora_fin)
                  ->where('hora_fin', '>', $request->hora_inicio);
        })
        ->exists();

    if ($existeReserva) {
        return redirect()->back()->with('error', 'Esa hora ya está reservada, por favor elige otra.');
    }

    // Crear la reserva
    Reserva::create([
        'parqueadero_id' => $request->parqueadero_id,
        'nombre_usuario' => $usuario,
        'hora_inicio' => $request->hora_inicio,
        'hora_fin' => $request->hora_fin,
    ]);

    // Reducir espacios disponibles en el parqueadero
    $parqueadero->decrement('espacios_disponibles');

    return redirect('/')->with('success', '✅ Reserva registrada exitosamente');
}


    public function disponibles()
    {
        $parqueaderos = Parqueadero::where('espacios_disponibles', '>', 0)->get();
        return view('parqueaderos.disponibles', compact('parqueaderos'));
    }



    // Mostrar formulario de edición
public function edit($id)
{
    $usuario = Session::get('usuario');
    if (!$usuario || $usuario->email !== 'admin@gmail.com') {
        return redirect('/')->with('error', 'Solo el administrador puede editar parqueaderos.');
    }

    $parqueadero = Parqueadero::findOrFail($id);
    return view('parqueaderos.editar', compact('parqueadero'));
}

// Guardar cambios del parqueadero
public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'ubicacion' => 'required|string|max:255',
        'espacios_disponibles' => 'required|integer|min:0',
        'precio_por_hora' => 'required|numeric|min:0',
    ]);

    $parqueadero = Parqueadero::findOrFail($id);
    $parqueadero->update($request->all());

    return redirect('/')->with('success', 'Parqueadero actualizado correctamente.');
}

// Eliminar parqueadero
public function destroy($id)
{
    $parqueadero = Parqueadero::findOrFail($id);
    $parqueadero->delete();

    return redirect('/')->with('success', 'Parqueadero eliminado correctamente.');
}



public function eliminarReserva($id)
{
    $usuario = Session::get('usuario');

    if (!$usuario || $usuario->email !== 'admin@gmail.com') {
        return redirect('/')->with('error', 'No tienes permisos para eliminar reservas.');
    }

    $reserva = Reserva::findOrFail($id);

    // Incrementar espacios disponibles en el parqueadero
    $parqueadero = Parqueadero::find($reserva->parqueadero_id);
    if ($parqueadero) {
        $parqueadero->increment('espacios_disponibles');
    }

    $reserva->delete();

    return redirect('/')->with('success', 'Reserva eliminada correctamente.');
}


}

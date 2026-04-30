<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Sirve para generar PDFs

class PartController extends Controller
{
    public function create()
    {
        return view('parts.create'); // La pantalla del formulario
    }

    public function store(Request $request)
{
    // Validamos: Si olvidas el P/N, el sistema te regañará (yo también)
    $validated = $request->validate([
        'part_number' => 'required|unique:parts,part_number',
        'name'        => 'required|string|max:255',
        'brand'       => 'nullable|string',
        'stock'       => 'required|integer|min:0',
        'category'    => 'required|string',
        'tags'        => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Subir imagen si existe
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('parts', 'public');
    }

    // Guardar en la base de datos
    \App\Models\Part::create($validated);

    return redirect()->route('dashboard')->with('success', 'Componente registrado correctamente.');
}

// Muestra el formulario con los datos de la pieza a editar
public function edit(Part $part)
{
    return view('parts.edit', compact('part'));
}

// Procesa la actualización
public function update(Request $request, Part $part)
{
    $validated = $request->validate([
        'part_number' => 'required|unique:parts,part_number,' . $part->id,
        'name'        => 'required|string|max:255',
        'brand'       => 'nullable|string',
        'stock'       => 'required|integer|min:0',
        'category'    => 'required|string',
        'tags'        => 'nullable|string',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('parts', 'public');
    }

    $part->update($validated);

    return redirect()->route('dashboard')->with('success', 'Componente actualizado.');
}

public function toggleStatus(Part $part)
{
    $part->is_active = !$part->is_active; // Si es true pasa a false, y viceversa
    $part->save();

    $mensaje = $part->is_active ? 'Componente reactivado.' : 'Componente marcado como inactivo.';
    return redirect()->back()->with('success', $mensaje);
}

//Funcion para despachar piezas a un avión Dispatch
public function dispatch(Request $request, Part $part)
{
    $request->validate([
        'quantity' => "required|integer|min:1|max:{$part->stock}",
        'aircraft_id' => 'required|exists:aircraft,id', // Validamos que el ID exista
    ]);

    $aircraft = \App\Models\Aircraft::findOrFail($request->aircraft_id);

    \App\Models\Movement::create([
        'part_id' => $part->id,
        'aircraft_id' => $aircraft->id, // ESTE ES EL QUE MANDA EN EL PDF
        'aircraft_registration' => $aircraft->registration, // ESTE EVITÓ EL ERROR DE ANTES
        'quantity' => $request->quantity,
        'user_id' => auth()->id(),
        'notes' => $request->notes,
    ]);

    $part->decrement('stock', $request->quantity);

    return redirect()->route('dashboard')->with('success', 'Despacho registrado.');
}// Mostrar formulario de despacho

public function showDispatch(Part $part)
{
    $aircrafts = \App\Models\Aircraft::where('is_active', true)->get();
    return view('parts.dispatch', compact('part', 'aircrafts'));
}

public function addStock(Request $request, Part $part)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'reference' => 'nullable|string|max:100', // Ej: Factura #123
    ]);

    // Registramos el movimiento (pero esta vez positivo)
    \App\Models\Movement::create([
        'part_id' => $part->id,
        'aircraft_registration' => 'ALMACÉN', // No va a un avión, entra al stock
        'quantity' => $request->quantity, // Podríamos guardarlo como positivo
        'user_id' => auth()->id(),
        'notes' => "ENTRADA DE MATERIAL. Ref: " . $request->reference,
    ]);

    // Sumamos al stock
    $part->increment('stock', $request->quantity);

    return redirect()->route('dashboard')->with('success', "Se han añadido {$request->quantity} unidades a {$part->part_number}");
}

// Mostrar formulario de reabastecimiento
public function showRestock(Part $part)
{
    return view('parts.restock', compact('part'));
}

// Procesar la entrada de material
public function restock(Request $request, Part $part)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
        'reference' => 'nullable|string|max:100', // Ej: Número de factura o proveedor
    ]);

    // 1. Registrar el movimiento de entrada
    \App\Models\Movement::create([
        'part_id' => $part->id,
        'aircraft_registration' => 'ALMACÉN', // Marcamos que entró al almacén, no a un avión
        'quantity' => $request->quantity,
        'user_id' => auth()->id(),
        'notes' => "REABASTECIMIENTO. Ref: " . ($request->reference ?? 'S/N'),
    ]);

    // 2. Incrementar el stock
    $part->increment('stock', $request->quantity);

    return redirect()->route('dashboard')->with('success', "Se han añadido {$request->quantity} unidades a {$part->part_number}.");
}

public function generateInventoryReport()
{
    $parts = Part::where('is_active', true)->orderBy('category')->get();
    
    // Fecha para el contenido del PDF (con diagonales está bien)
    $dateContent = now()->format('d/m/Y H:i');
    
    // Fecha para el NOMBRE DEL ARCHIVO (sin diagonales para que no explote)
    $dateFile = now()->format('d-m-Y_H-i');

    $pdf = Pdf::loadView('reports.inventory', [
        'parts' => $parts,
        'date' => $dateContent
    ]);

    // Usamos la fecha con guiones aquí
    return $pdf->download("Inventario_SkyNode_{$dateFile}.pdf");
}
}

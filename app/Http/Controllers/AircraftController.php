<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage; // Asegúrate de importar Storage si lo necesitas para manejar archivos
use App\Models\Aircraft; // Asegúrate de importar el modelo Aircraft
use Illuminate\Http\Request; // Asegúrate de importar Request para manejar las solicitudes HTTP

class AircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fleet = \App\Models\Aircraft::all();
        return view('aircraft.index', compact('fleet')); // Asegúrate de tener esta vista creada para mostrar la flota
        // Aquí podrías mostrar la lista de aeronaves en la flota, con opciones para editar o eliminar cada una.
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $registration = strtoupper(trim($request->registration));

    $request->validate([
        'registration' => 'required|unique:aircraft,registration',
        'model' => 'required|string|max:100',
    ]);

    // AQUÍ ESTABA EL ERROR. Quitamos un "Models\"
    \App\Models\Aircraft::create([
        'registration' => $registration, 
        'model' => $request->model,
        'serial_number' => $request->serial_number,
        'is_active' => true,
    ]);

    return redirect()->route('aircraft.index')->with('success', '¡Aeronave registrada con éxito!');
}

    /**
     * Display the specified resource.
     */
    public function show(Aircraft $aircraft)
    {
        // 1. Cargamos todo lo necesario en una sola línea limpia
        $movements = $aircraft->movements()->with(['part', 'user'])->latest()->get();
        
        // 2. Calculamos el total
        $totalParts = $movements->sum('quantity');

        // 3. Un UNICO return con todas las variables
        return view('aircraft.show', compact('aircraft', 'movements', 'totalParts'));

        // Cargamos el avión CON sus movimientos y sus documentos de un solo golpe
        $aircraft->load(['movements.part', 'movements.user', 'documents.user']);
        
        $movements = $aircraft->movements;
        $totalParts = $movements->sum('quantity');

        return view('aircraft.show', compact('aircraft', 'movements', 'totalParts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

public function uploadPhoto(Request $request, Aircraft $aircraft)
{
    $request->validate([
        'photo' => 'required|image|max:2048',
    ]);

    $path = $request->file('photo')->store('aircraft_photos', 'public');

    // ESTA LÍNEA ES LA QUE ESCRIBE EN LA DB:
    $aircraft->update(['image' => $path]); 

    return back()->with('success', 'Foto actualizada');
}

public function uploadDocument(Request $request, Aircraft $aircraft)
{
    $request->validate([
        'document' => 'required|mimes:pdf,doc,docx,jpg,png|max:5120', // Max 5MB
        'name' => 'required|string|max:100', // Nombre del documento (ej. Seguro 2024)
    ]);

    // Guardar el documento
    $path = $request->file('document')->store('aircraft_documents/' . $aircraft->id, 'public');

    // Aquí necesitamos un Modelo/Tabla para documentos. Asumamos que ya la creamos (ver Paso 5).
    $aircraft->documents()->create([
        'name' => $request->name,
        'path' => $path,
        'user_id' => auth()->id(),
    ]);

    return back()->with('success', 'Documento subido correctamente.');
}   
}


// En el modelo Aircraft.php, asegúrate de tener el campo 'image' en $fillable para que se guarde correctamente en la base de datos.
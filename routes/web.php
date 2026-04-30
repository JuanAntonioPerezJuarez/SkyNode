<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartController;
use App\Models\Part;
use Illuminate\Http\Request;
use App\Http\Controllers\MovementController; // Importamos el controlador de movimientos
use App\Http\Controllers\AircraftController; // Importamos el controlador de aeronaves

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function (Request $request) {
    // 1. Iniciamos la consulta para la tabla principal
    $query = Part::query();

    // 2. Aplicamos tu lógica de búsqueda (P/N, Nombre, Marca, Tags, Categoría)
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('part_number', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%")
              ->orWhere('brand', 'like', "%{$search}%")
              ->orWhere('tags', 'like', "%{$search}%")
              ->orWhere('category', 'like', "%{$search}%");
        });
    }

    // Obtenemos las piezas para la tabla
    $parts = $query->latest()->get();
    
    // 3. Calculamos las piezas con stock crítico (Menos de 5 unidades)
    // Solo tomamos las que están activas para no dar falsas alarmas
    $lowStockParts = Part::where('is_active', true)
                         ->where('stock', '<', 5)
                         ->get();
    
    // 4. PASAMOS AMBAS VARIABLES (Importante para evitar el error de "Undefined variable")
    return view('dashboard', compact('parts', 'lowStockParts'));

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Solo los admins pueden acceder a estas rutas para gestionar las piezas y movimientos, así como generar reportes.
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/parts/create', [PartController::class, 'create'])->name('parts.create');
    Route::post('/parts', [PartController::class, 'store'])->name('parts.store');

    Route::get('/parts/{part}/edit', [PartController::class, 'edit'])->name('parts.edit');
    Route::put('/parts/{part}', [PartController::class, 'update'])->name('parts.update');
    Route::patch('/parts/{part}/status', [PartController::class, 'toggleStatus'])->name('parts.toggle');
    Route::get('/movements', [MovementController::class, 'index'])->middleware(['auth'])->name('movements.index');

    Route::get('/parts/{part}/restock', [PartController::class, 'showRestock'])->name('parts.restock');
    Route::post('/parts/{part}/restock', [PartController::class, 'restock'])->name('parts.restock.store');

    Route::get('/report/inventory', [PartController::class, 'generateInventoryReport'])->name('report.inventory'); //generar reporte de inventario

    Route::resource('aircraft', AircraftController::class)->middleware('auth'); // Rutas para gestionar aeronaves (CRUD)

    Route::middleware(['auth', 'verified'])->group(function () {
    // Estas son las que necesitamos que funcionen
    Route::resource('aircraft', AircraftController::class);
    Route::get('/movements', [MovementController::class, 'index'])->name('movements.index'); // Ruta para ver el historial de movimientos

    Route::get('/report/movements', [MovementController::class, 'generateHistoryReport'])->name('report.movements'); // Ruta para generar el reporte de movimientos

    // Rutas dentro de tu AircraftController o en un nuevo DocumentsController si prefieres
    Route::post('/aircraft/{aircraft}/photo', [AircraftController::class, 'uploadPhoto'])->name('aircraft.photo');
    Route::post('/aircraft/{aircraft}/document', [AircraftController::class, 'uploadDocument'])->name('aircraft.document');
});
});     

Route::get('/parts/{part}/dispatch', [PartController::class, 'showDispatch'])->name('parts.dispatch');
Route::post('/parts/{part}/dispatch', [PartController::class, 'dispatch'])->name('parts.dispatch.store');
// Asegúrate de que esta línea esté cerca de las otras de aircraft
Route::get('/aircraft/{aircraft}', [AircraftController::class, 'show'])->name('aircraft.show');

require __DIR__.'/auth.php';

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movement; // <--- ESTA ES LA LÍNEA QUE FALTA
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de tener esta línea para usar DomPDF

class MovementController extends Controller
{
    public function index()
{
    // Traemos los movimientos con su pieza y usuario (Eager Loading para que sea rápido)
    $movements = \App\Models\Movement::with(['part', 'user'])->latest()->get();
    return view('movements.index', compact('movements'));
}

public function generateHistoryReport()
{
    // Obtenemos los movimientos con sus relaciones para no hacer mil consultas
    $movements = Movement::with(['part', 'aircraft', 'user'])->latest()->get();
    $date = now()->format('d/m/Y H:i');
    $fileName = 'Historial_Movimientos_' . now()->format('d-m-Y_Hi') . '.pdf';

    $pdf = Pdf::loadView('reports.movements', compact('movements', 'date'));

    return $pdf->download($fileName);
}
}

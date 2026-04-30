<!DOCTYPE html>
<html>
<head>
    <title>Historial de Movimientos - SkyNode</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 20px; font-weight: bold; color: #1e40af; text-transform: uppercase; }
        .timestamp { text-align: right; font-size: 8px; color: #666; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background-color: #f3f4f6; border: 1px solid #d1d5db; padding: 6px; text-align: left; text-transform: uppercase; }
        td { border: 1px solid #d1d5db; padding: 6px; vertical-align: top; }
        .type-in { color: green; font-weight: bold; }
        .type-out { color: red; font-weight: bold; }
        .footer { margin-top: 50px; }
        .signature-box { float: left; width: 45%; text-align: center; margin-top: 40px; }
        .line { border-top: 1px solid #000; width: 80%; margin: 0 auto 5px auto; }
    </style>
</head>
<body>
    <div class="timestamp">Fecha de impresión: {{ $date }}</div>
    
    <div class="header">
        <div class="logo">SkyNode - Gestión de Almacén Aeronáutico</div>
        <div style="font-size: 12px;">Bitácora Histórica de Entradas y Salidas</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>P/N & Descripción</th>
                <th>Tipo</th>
                <th>Cant.</th>
                <th>Destino / Aeronave</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movements as $m)
            <tr>
                <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <strong>{{ $m->part->part_number }}</strong><br>
                    <span style="font-size: 8px;">{{ $m->part->name }}</span>
                </td>
                <td class="{{ $m->aircraft_id ? 'type-out' : 'type-in' }}">
                    {{ $m->aircraft_id ? 'SALIDA' : 'ENTRADA' }}
                </td>
                <td>{{ $m->quantity }}</td>
                <td>
                    @if($m->aircraft)
                        {{ $m->aircraft->registration }} ({{ $m->aircraft->model }})
                    @else
                        Ingreso a Stock
                    @endif
                    @if($m->notes)
                        <br><i style="font-size: 8px; color: #777;">Obs: {{ $m->notes }}</i>
                    @endif
                </td>
                <td>{{ $m->user->name ?? 'Sistema' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <div class="line"></div>
            <p>Firma del Responsable de Almacén</p>
        </div>
        <div class="signature-box" style="float: right;">
            <div class="line"></div>
            <p>Sello de Control de Calidad</p>
        </div>
    </div>
</body>
</html>
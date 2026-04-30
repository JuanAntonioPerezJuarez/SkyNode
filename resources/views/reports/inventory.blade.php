<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Inventario - SkyNode</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .logo { font-size: 24px; font-weight: bold; color: #1e40af; }
        .timestamp { text-align: right; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 50px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { bg-color: #f2f2f2; }
        .signature-section { margin-top: 100px; }
        .signature-box { float: left; width: 45%; text-align: center; }
        .line { border-top: 1px solid #000; width: 80%; margin: 0 auto 5px auto; }
    </style>
</head>
<body>
    <div class="timestamp">Generado el: {{ $date }}</div>
    
    <div class="header">
        <div class="logo">SKYNODE - GESTIÓN AERONÁUTICA</div>
        <div style="font-size: 14px;">Reporte General de Existencias en Almacén</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>P/N</th>
                <th>Descripción</th>
                <th>Marca</th>
                <th>Categoría</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parts as $part)
            <tr>
                <td><strong>{{ $part->part_number }}</strong></td>
                <td>{{ $part->name }}</td>
                <td>{{ $part->brand }}</td>
                <td>{{ $part->category }}</td>
                <td style="{{ $part->stock < 5 ? 'color: red; font-weight: bold;' : '' }}">
                    {{ $part->stock }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <div class="line"></div>
            <p>Responsable de Almacén<br>(Firma y Sello)</p>
        </div>
        <div class="signature-box" style="float: right;">
            <div class="line"></div>
            <p>Control de Calidad / Inspección<br>Fecha: ____/____/____</p>
        </div>
    </div>
</body>
</html>
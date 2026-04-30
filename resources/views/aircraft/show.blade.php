<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expediente: {{ $aircraft->registration }}
            </h2>
            <a href="{{ route('aircraft.index') }}" class="text-sm text-blue-600 hover:underline">← Volver a la flota</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-1/3 p-2 bg-gray-50 rounded-lg border">
                        @if($aircraft->image)
                            <img src="{{ url('storage/' . $aircraft->image) }}" 
                            alt="Foto de {{ $aircraft->registration }}" 
                            class="w-full h-48 object-cover rounded-lg shadow"
                            onerror="this.src='https://placehold.co/600x400?text=Error+al+cargar+Imagen'">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-400">
                                <span class="text-gray-500 text-xs">[ Sin Foto ]</span>
                            </div>
                        @endif
                        
                        <form action="{{ route('aircraft.photo', $aircraft->id) }}" method="POST" enctype="multipart/form-data" class="mt-2 text-center">
                            @csrf
                            <label class="block text-xs text-gray-600 mb-1">Cambiar Foto (JPG/PNG)</label>
                            <input type="file" name="photo" class="text-xs w-full mb-1" required>
                            <button type="submit" class="bg-gray-800 text-white text-xs px-3 py-1 rounded">Subir Foto Pro</button>
                        </form>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-blue-900">{{ $aircraft->model }}</h3>
                        <p class="text-gray-600 uppercase">Serie: {{ $aircraft->serial_number ?? 'No registrado' }}</p>
                        <div class="mt-4 grid grid-cols-2 gap-4">

                        
                            <div class="bg-blue-50 p-3 rounded shadow-sm">
                                <span class="block text-xs uppercase text-gray-500">Estado</span>
                                <span class="font-bold text-green-600">Aeronavegable / Activo</span>
                            </div>
                            <div class="bg-blue-50 p-3 rounded shadow-sm">
                                <span class="block text-xs uppercase text-gray-500">Piezas Instaladas</span>
                                <span class="font-bold text-blue-800">{{ $totalParts }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">

                        
                        
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h4 class="font-bold text-lg mb-4 text-gray-700 italic border-b pb-2">Log de Componentes Instalados</h4>
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="p-3">Fecha</th>
                            <th class="p-3">P/N</th>
                            <th class="p-3">Descripción</th>
                            <th class="p-3">Cant.</th>
                            <th class="p-3">Mecánico/Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $m)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 text-gray-500">{{ $m->created_at->format('d/m/Y') }}</td>
                            <td class="p-3 font-mono font-bold text-blue-700">{{ $m->part->part_number }}</td>
                            <td class="p-3">{{ $m->part->name }}</td>
                            <td class="p-3 font-bold">{{ $m->quantity }}</td>
                            <td class="p-3 text-gray-600">{{ $m->user->name }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-400">No hay registros de mantenimiento para esta aeronave.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h4 class="font-bold text-lg mb-4 text-gray-700 italic border-b pb-2">Documentos Técnicos y Legales</h4>
                <p class="text-gray-600">Aquí se mostrarán los documentos relacionados con esta aeronave, como certificados de aeronavegabilidad, manuales técnicos, registros de mantenimiento, etc. Esta sección está en desarrollo.</p>

                <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                @forelse($aircraft->documents as $doc)
                                <div class="flex justify-between items-center bg-gray-50 p-3 mb-2 rounded border hover:bg-gray-100">
                                    <div>
                                        <span class="font-bold text-sm">{{ $doc->name }}</span><br>
                                        <small class="text-gray-500">Subido: {{ $doc->created_at->format('d/m/Y') }} por {{ $doc->user->name }}</small>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ asset('storage/' . $doc->path) }}" target="_blank" class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded">Ver/Descargar</a>
                                        </div>
                                </div>
                                @empty
                                <p class="text-center text-gray-400 text-sm py-4 border border-dashed rounded-lg">No hay documentos subidos aún.</p>
                                @endforelse
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                                <form action="{{ route('aircraft.document', $aircraft->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="block text-sm font-semibold text-gray-700">Nombre del Documento</label>
                                        <input type="text" name="name" placeholder="Ej. Seguro de Casco 2024" class="w-full text-sm rounded border-gray-300" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="block text-sm font-semibold text-gray-700">Archivo (PDF, DOC, Imagen)</label>
                                        <input type="file" name="document" class="w-full text-xs" required>
                                    </div>
                                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 rounded text-sm">Subir Documento</button>
                                </form>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</x-app-layout>
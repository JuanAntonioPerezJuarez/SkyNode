<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Libro de Bitácora: Movimientos de Almacén') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-bold text-gray-700">Registros Recientes</h3>
    
    <a href="{{ route('report.movements') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Exportar Historial (PDF)
    </a>
</div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">P/N</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pieza</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Matrícula</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Cant.</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Usuario</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($movements as $mov)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 text-sm font-mono font-bold text-blue-600">{{ $mov->part->part_number }}</td>
                            <td class="px-6 py-4 text-sm">{{ $mov->part->name }}</td>
                            <td class="px-6 py-4 text-sm font-bold">{{ $mov->aircraft_registration }}</td>
                            <td class="px-6 py-4 text-sm font-bold">
                                @if($mov->aircraft_registration === 'ALMACÉN')
                                    <span class="text-green-600">+{{ $mov->quantity }}</span>
                                @else
                                    <span class="text-red-600">-{{ $mov->quantity }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $mov->user->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
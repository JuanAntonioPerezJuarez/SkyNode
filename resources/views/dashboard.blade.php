<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inventario de Almacén') }}
            </h2>
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('parts.create') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + Registrar Parte
                </a>

                <a href="{{ route('report.inventory') }}" class="bg-gray-800 text-white px-4 py-2 rounded-md font-bold flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Descargar Inventario (PDF)
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($lowStockParts->count() > 0)
                    <div class="mb-6 p-4 bg-orange-50 border-l-4 border-orange-500 rounded-r-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="text-orange-800 font-bold">¡Atención! Hay {{ $lowStockParts->count() }} componentes con stock crítico.</h3>
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach($lowStockParts as $lp)
                                <span class="text-xs bg-orange-200 text-orange-800 px-2 py-1 rounded">
                                    {{ $lp->part_number }}: {{ $lp->stock }} left
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                    <div class="mb-6">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2">
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    placeholder="Buscar por P/N, Marca, Modelo (Cessna)..." 
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-slate-500 focus:border-slate-500 sm:text-sm">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-slate-600 text-white rounded-md hover:bg-slate-700 transition">
                                Filtrar
                            </button>
                            @if(request('search'))
                                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                    Limpiar
                                </a>
                            @endif
                        </form>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">P/N</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marca</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Stock</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($parts as $part)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($part->image)
                                        <img src="{{ asset('storage/' . $part->image) }}" class="h-10 w-10 rounded-md object-cover border">
                                    @else
                                        <div class="h-10 w-10 bg-gray-100 rounded-md flex items-center justify-center text-[10px] text-gray-400">N/A</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-mono text-sm font-bold text-blue-600">
                                    {{ $part->part_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    {{ $part->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-semibold">
                                    {{ $part->brand }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 text-slate-800">
                                        {{ $part->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="px-3 py-1 rounded {{ $part->stock < 5 ? 'bg-red-100 text-red-700 font-bold' : 'bg-green-100 text-green-700' }}">
                                        {{ $part->stock }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-3">
                                    <a href="{{ route('parts.edit', $part) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Editar</a>
                                    
                                    <form action="{{ route('parts.toggle', $part) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="{{ $part->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-3 py-1 rounded font-bold transition">
                                            {{ $part->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('parts.dispatch', $part) }}" class="text-red-600 hover:text-gray-900 font-bold">Despachar</a>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('parts.restock', $part) }}" class="text-green-600 hover:text-green-900 font-bold">Reabastecer</a>
                                </td>


                                <tr class="{{ $part->is_active ? '' : 'bg-gray-100 opacity-60' }} hover:bg-gray-50 transition">
                                </tr>

                                
                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>

                    @if($parts->isEmpty())
                        <p class="text-center py-10 text-gray-500">No hay componentes registrados en el hangar.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
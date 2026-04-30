<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Componente: ') }} <span class="text-blue-600">{{ $part->part_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 border-b border-gray-200 shadow-xl rounded-lg">
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('parts.update', $part) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Número de Parte (P/N)</label>
                            <input type="text" name="part_number" value="{{ old('part_number', $part->part_number) }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Nombre del Componente</label>
                            <input type="text" name="name" value="{{ old('name', $part->name) }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Marca / Fabricante</label>
                            <input type="text" name="brand" value="{{ old('brand', $part->brand) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Cantidad en Almacén</label>
                            <input type="number" name="stock" value="{{ old('stock', $part->stock) }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Categoría</label>
                            <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @php $cats = ['Motor', 'Bujías', 'Planeador', 'Consumibles', 'Electrónica']; @endphp
                                @foreach($cats as $cat)
                                    <option value="{{ $cat }}" {{ $part->category == $cat ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Modelos Compatibles (Tags)</label>
                            <input type="text" name="tags" value="{{ old('tags', $part->tags) }}" 
                                placeholder="Cessna 172, Piper..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Imagen del Componente</label>
                            <div class="flex items-center gap-4">
                                @if($part->image)
                                    <div class="shrink-0">
                                        <img src="{{ asset('storage/' . $part->image) }}" class="h-20 w-20 object-cover rounded-md border">
                                        <p class="text-[10px] text-gray-500 text-center mt-1 text-uppercase">Actual</p>
                                    </div>
                                @endif
                                <input type="file" name="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <div class="col-span-1 md:col-span-2 flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-blue-700 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-800 transition">
                                Guardar Cambios
                            </button>
                            <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-gray-700 font-bold py-3 px-4 rounded-md text-center hover:bg-gray-300 transition">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
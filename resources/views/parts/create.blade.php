<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Logística de Almacén: Entrada de Componente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 border-b border-gray-200 shadow-xl rounded-lg">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-600 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('parts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Número de Parte (P/N)</label>
                            <input type="text" name="part_number" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Nombre del Componente</label>
                            <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Marca / Fabricante</label>
                            <input type="text" name="brand" placeholder="Ej. Cessna, Lycoming" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Cantidad Inicial</label>
                            <input type="number" name="stock" value="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Categoría</label>
                            <select name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="Motor">Motor</option>
                                <option value="Bujías">Bujías</option>
                                <option value="Planeador">Planeador</option>
                                <option value="Consumibles">Consumibles</option>
                                <option value="Electrónica">Electrónica</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Modelos Compatibles (Tags)</label>
                            <input type="text" name="tags" placeholder="Separados por comas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Imagen de Referencia</label>
                            <input type="file" name="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="col-span-2 pt-4">
                            <button type="submit" class="w-full bg-slate-800 text-white font-bold py-3 px-4 rounded-md hover:bg-slate-700 transition">
                                Registrar en Almacén
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
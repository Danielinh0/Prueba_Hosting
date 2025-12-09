@extends('layouts.app')

@section('header')
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generar Reportes Excel') }}
        </h2>
    </div>
@endsection

@section('content')
<div class="py-12 w-full">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Seleccione el rango de fechas para generar los reportes</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Reporte Eventos -->
                <div class="border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-indigo-100 text-indigo-600 mb-4">
                            <i class="fa-solid fa-calendar-days text-xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Eventos</h4>
                        <p class="text-sm text-gray-500 mt-1">Reporte de eventos y registros</p>
                    </div>
                    
                    <form action="{{ route('admin.reportes.eventos') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="fecha_inicio_eventos" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio_eventos" max="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="fecha_fin_eventos" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin_eventos" max="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" 
                                class="flex-1 inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                <i class="fa-solid fa-file-excel mr-2"></i> Excel
                            </button>
                            <button type="submit" formaction="{{ route('admin.reportes.eventos.pdf') }}"
                                class="flex-1 inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <i class="fa-solid fa-file-pdf mr-2"></i> PDF
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reporte Proyectos -->
                <div class="border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-emerald-100 text-emerald-600 mb-4">
                            <i class="fa-solid fa-laptop-code text-xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Proyectos</h4>
                        <p class="text-sm text-gray-500 mt-1">Reporte de proyectos inscritos</p>
                    </div>

                     <form action="{{ route('admin.reportes.proyectos') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="fecha_inicio_proyectos" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio_proyectos" max="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="fecha_fin_proyectos" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin_proyectos" max="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                        </div>
                        <div class="flex gap-2">
                             <button type="submit" 
                                class="flex-1 inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                                <i class="fa-solid fa-file-excel mr-2"></i> Excel
                            </button>
                            <button type="submit" formaction="{{ route('admin.reportes.proyectos.pdf') }}"
                                class="flex-1 inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <i class="fa-solid fa-file-pdf mr-2"></i> PDF
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reporte Equipos -->
                <div class="border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-center mb-6">
                        <div class="inline-flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600 mb-4">
                            <i class="fa-solid fa-users text-xl"></i>
                        </div>
                        <h4 class="text-lg font-bold text-gray-900">Equipos</h4>
                        <p class="text-sm text-gray-500 mt-1">Reporte de equipos registrados</p>
                    </div>

                     <form action="{{ route('admin.reportes.equipos') }}" method="GET" class="space-y-4">
                        <div>
                            <label for="fecha_inicio_equipos" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio_equipos" max="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="fecha_fin_equipos" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin_equipos" max="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" 
                                class="flex-1 inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fa-solid fa-file-excel mr-2"></i> Excel
                            </button>
                            <button type="submit" formaction="{{ route('admin.reportes.equipos.pdf') }}"
                                class="flex-1 inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <i class="fa-solid fa-file-pdf mr-2"></i> PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-8 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-info text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Nota:</strong> Para asegurar la relevancia de los datos, todos los reportes requieren seleccionar un rango de fechas de <strong>mínimo una semana</strong> (7 días).
                        </p>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="mt-4 p-4 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-exclamation text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Se encontraron errores:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

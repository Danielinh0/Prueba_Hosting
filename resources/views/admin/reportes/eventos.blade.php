<!DOCTYPE html>
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        .body { font-family: 'Poppins', sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { vertical-align: middle; }
        .header-text { display: inline-block; vertical-align: middle; margin-left: 10px; font-weight: bold; font-size: 16pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000000; padding: 5px; text-align: center; }
        th { background-color: #ccccccff; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logito.png') }}" width="50" height="50" alt="Logo">
        <span class="header-text">Instituto Tecnológico de Oaxaca<br>Reporte de Eventos</span>
    </div>
    
    <div style="text-align: center; margin-bottom: 15px;">
        <strong>Fecha de Generación:</strong> {{ date('d/m/Y') }} <br>
        <strong>Periodo:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Equipos Inscritos</th>
                <th>Ganadores / Estatus</th>
            </tr>
        </thead>
        <tbody>
            @if($eventos->count() > 0)
                @foreach($eventos as $evento)
                    <tr>
                        <td>{{ $evento->nombre }}</td>
                        <td>{{ $evento->estado }}</td>
                        <td>{{ $evento->fecha_inicio->format('d/m/Y') }}</td>
                        <td>{{ $evento->fecha_fin->format('d/m/Y') }}</td>
                        <td>{{ $evento->inscripciones_count }}</td>
                        <td>
                            @if($evento->estado === 'Finalizado')
                                @php
                                    $ganadores = $evento->inscripciones->whereNotNull('puesto_ganador')->sortBy('puesto_ganador')->take(3);
                                @endphp
                                @if($ganadores->count() > 0)
                                    @foreach($ganadores as $ganador)
                                        <div>{{ $ganador->puesto_ganador }}° - {{ $ganador->equipo->nombre ?? 'Sin Nombre' }}</div>
                                    @endforeach
                                @else
                                    Sin ganadores registrados
                                @endif
                            @else
                                Compitiendo
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" style="text-align: center;">En este periodo no se registró ningún evento.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        .body { font-family: 'Poppins', sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img {vertical-align: middle; }
        .header-text { display: inline-block; vertical-align: middle; margin-left: 10px; font-weight: bold; font-size: 16pt; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000000; padding: 5px; text-align: center; }
        th { background-color: #cccccc; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logito.png') }}" width="50" height="50" alt="Logo">
        <span class="header-text">Instituto Tecnológico de Oaxaca<br>Reporte de Equipos</span>
    </div>

    <div style="text-align: center; margin-bottom: 15px;">
        <strong>Fecha de Generación:</strong> {{ date('d/m/Y') }} <br>
        <strong>Periodo:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Nombre Equipo</th>
                <th>Eventos Inscritos</th>
                <th>Fecha Creación</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @if($equipos->count() > 0)
                @foreach($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->nombre }}</td>
                        <td>
                            @foreach($equipo->inscripciones as $inscripcion)
                                {{ $inscripcion->evento->nombre ?? '' }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>{{ $equipo->created_at ? $equipo->created_at->format('d/m/Y') : 'N/A' }}</td>
                        <td>{{ $equipo->descripcion }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center;">En este periodo no se registró ningún equipo.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>

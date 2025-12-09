<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700;900&family=Open+Sans:wght@400;600&display=swap');
        
        @page {
            margin: 1cm;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .border-outer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 5px solid #1a237e; /* Azul oscuro */
            padding: 5px;
        }

        .border-inner {
            height: 85%;
            border: 2px solid #c5a14d; /* Dorado */
            padding: 2cm;
            position: relative;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .header-table img {
            height: 80px;
            object-fit: contain;
        }

        .text-center {
            text-align: center;
        }

        .event-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .platform-text {
            font-size: 10px;
            color: #666;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .otorga-text {
            color: #c5a14d;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .diploma-title {
            color: #1a237e;
            font-size: 48px;
            font-weight: bold;
            margin: 10px 0;
            letter-spacing: 3px;
        }

        .a-text {
            color: #c5a14d;
            font-size: 14px;
            font-weight: bold;
            margin: 10px 0;
        }

        .student-name {
            font-size: 28px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            color: #000;
        }

        .body-text {
            font-family: 'Open Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0 40px;
            color: #444;
        }

        .body-text b {
            color: #1a237e;
        }

        .dates-text {
            font-size: 10px;
            font-style: italic;
            color: #666;
            margin-top: 30px;
            text-transform: uppercase;
        }

        .signatures-table {
            width: 100%;
            margin-top: 0px;
            position: absolute;
            bottom: 50px;
            left: 0px;
        }

        .signature-line {
            width: 80%;
            border-top: 1px solid #777;
            margin: 0 auto 5px auto;
        }

        .signature-name {
            font-weight: bold;
            font-size: 11px;
            color: #1a237e;
        }

        .signature-title {
            font-size: 9px;
            color: #555;
        }

    </style>
</head>
<body>
    <div class="border-outer">
        <div class="border-inner">
            <!-- Header Logos -->
            <table class="header-table">
                <tr>
                    <!-- Placeholder TecNM (Left) -->
                    <td align="left" width="20%">
                        <img src="{{ public_path('images/logo_azul.png') }}" alt="TecNM">
                    </td>
                    <!-- Placeholder Evento (Center) -->
                    <td align="center" width="60%">
                        <!-- <img src="..." alt="Evento"> -->
                    </td>
                    <!-- Logo ITO (Right) -->
                    <td align="right" width="20%">
                        <img src="{{ public_path('images/logito.png') }}" alt="ITO">
                    </td>
                </tr>
            </table>

            <div class="text-center">
                <div class="event-title">EL EVENTO ACADÉMICO {{ $evento->nombre }}</div>
                <div class="platform-text">A TRAVÉS DE LA PLATAFORMA DE GESTIÓN EDUCATIVA</div>
                
                <div class="otorga-text">OTORGA EL PRESENTE</div>
                
                <div class="diploma-title">DIPLOMA</div>
                
                <div class="a-text">A</div>
                
                <div class="student-name">
                    {{ $user->nombre }} {{ $user->app_paterno }} {{ $user->app_materno }}
                </div>

                <div class="body-text">
                    POR HABER 
                    @if($puesto > 0)
                        OBTENIDO EL <b>{{ $puesto }}° LUGAR</b>
                    @else
                        PARTICIPADO
                    @endif
                    EN EL EVENTO <b>{{ $evento->nombre }}</b>,
                    @if(isset($equipo))
                        COMO INTEGRANTE DEL EQUIPO <b>{{ $equipo->nombre }}</b>,
                    @endif
                    DEMOSTRANDO SU COMPROMISO Y HABILIDADES TÉCNICAS.
                </div>

                <div class="dates-text">
                    CELEBRADO DEL {{ $evento->fecha_inicio->format('d \d\e F \d\e Y') }} 
                    AL {{ $evento->fecha_fin->format('d \d\e F \d\e Y') }}.
                </div>

            </div>

             <table class="signatures-table">
                <tr>
                    <td align="center" width="50%">
                        <div class="signature-line"></div>
                        <div class="signature-name">COMITÉ ACADÉMICO</div>
                         <div class="signature-title">{{ $evento->nombre }}</div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</body>
</html>
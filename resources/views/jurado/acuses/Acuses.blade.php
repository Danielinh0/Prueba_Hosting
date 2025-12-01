@extends('jurado.layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    .acuses-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        font-family: 'Poppins', sans-serif;
    }

    .acuses-card {
        background-color: #FFF8F0; /* Color crema claro del dashboard */
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .acuses-header {
        background-color: #DB8C57; /* Color primario del dashboard */
        color: white;
        padding: 15px 30px;
        text-align: center;
        font-weight: 600;
        font-size: 1.2rem;
    }

    .acuses-body {
        padding: 40px 50px;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .form-group {
        margin-bottom: 30px;
    }

    .form-label {
        display: block;
        color: #000000; /* Texto oscuro del dashboard */
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 15px;
    }

    .custom-input-display {
        background-color: #FCFCFC; /* Fondo input del dashboard */
        width: 100%;
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        position: relative;
        cursor: pointer;
    }

    .custom-select {
        width: 100%;
        height: 100%;
        padding: 15px 50px 15px 20px; /* Padding derecho extra para el icono */
        background: transparent;
        border: none;
        font-size: 1.1rem;
        font-weight: 500;
        color: #A4AEB7; /* Texto gris del dashboard */
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
    }

    .custom-select:focus {
        outline: none;
    }

    .select-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: #A4AEB7;
    }

    .acuses-footer {
        display: flex;
        justify-content: flex-end;
        margin-top: auto;
    }

    .btn-buscar {
        background-color: #EBC08D; /* Color dorado suave del dashboard */
        color: white;
        border: none;
        padding: 12px 35px;
        border-radius: 12px; /* Radio de borde del dashboard */
        font-weight: 600;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: background-color 0.3s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .btn-buscar:hover {
        background-color: #dca970;
    }

    .btn-buscar svg {
        width: 20px;
        height: 20px;
        stroke-width: 2.5;
    }
</style>

<div class="acuses-container">
    <div class="acuses-card">
        <div class="acuses-header">
            Acuses disponibles
        </div>
        <div class="acuses-body">
            <div class="form-group">
                <label class="form-label">Acuses</label>
                <div class="custom-input-display">
                    <select name="evento_id" class="custom-select">
                        <option value="" disabled selected>Selecciona un evento</option>
                        @foreach($eventos as $evento)
                            <option value="{{ $evento->id_evento }}">{{ $evento->nombre }}</option>
                        @endforeach
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="select-icon" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
            
            <div class="acuses-footer">
                <button class="btn-buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5" />
                    </svg>
                    Guardar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
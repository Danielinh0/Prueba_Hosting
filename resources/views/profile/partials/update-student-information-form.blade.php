{{-- Vista de solo lectura para información de estudiante --}}
<section>
    <div class="space-y-4">
        <!-- Número de Control -->
        <div class="info-field">
            <span class="info-label">Número de Control</span>
            <div class="info-value">
                {{ $user->estudiante->numero_control ?? 'No disponible' }}
            </div>
        </div>

        <!-- Carrera -->
        <div class="info-field">
            <span class="info-label">Carrera</span>
            <div class="info-value">
                {{ $user->estudiante->carrera->nombre ?? 'No especificada' }}
            </div>
        </div>

        <!-- Semestre -->
        <div class="info-field">
            <span class="info-label">Semestre</span>
            <div class="info-value">
                {{ $user->estudiante->semestre ?? 'No especificado' }}° Semestre
            </div>
        </div>

        <!-- Nota de solo lectura -->
        <div class="readonly-note">
            <span style="color: #fca542;">
                Esta información es proporcionada por tu institución y no puede ser modificada desde esta plataforma.
                Si necesitas corregir algún dato, contacta a la administración de tu carrera.
            </span>
        </div>
    </div>
</section>
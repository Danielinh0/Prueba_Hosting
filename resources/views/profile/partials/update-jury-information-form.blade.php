<section>
    <form method="post" action="{{ route('profile.jury.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Campos en vertical -->
        <div class="space-y-6">
            <div class="info-field">
                <label for="especialidad" class="info-label">Especialidad</label>
                <input type="text" id="especialidad" name="especialidad" 
                       class="neuromorphic-input jurado-input"
                       value="{{ old('especialidad', $user->jurado->especialidad) }}"
                       placeholder="Ingresa tu especialidad">
                @error('especialidad')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="info-field">
                <label for="empresa_institucion" class="info-label">Empresa/Institución</label>
                <input type="text" id="empresa_institucion" name="empresa_institucion" 
                       class="neuromorphic-input jurado-input"
                       value="{{ old('empresa_institucion', $user->jurado->empresa_institucion) }}"
                       placeholder="Nombre de la empresa o institución">
                @error('empresa_institucion')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="info-field">
                <label for="cedula_profesional" class="info-label">Cédula Profesional</label>
                <input type="text" id="cedula_profesional" name="cedula_profesional" 
                       class="neuromorphic-input jurado-input"
                       value="{{ old('cedula_profesional', $user->jurado->cedula_profesional) }}"
                       placeholder="Número de cédula profesional">
                @error('cedula_profesional')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="neuromorphic-button">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Actualizar Información de Jurado
            </button>

            @if (session('status') === 'jury-info-updated')
                <div class="flex items-center text-green-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>¡Actualizado!</span>
                </div>
            @endif
        </div>
    </form>
</section>
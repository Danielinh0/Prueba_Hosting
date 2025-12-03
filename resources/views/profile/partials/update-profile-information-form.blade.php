<section>
    <div class="space-y-6">
        <!-- Foto de perfil -->
        <div class="flex flex-col items-center mb-6">
            <div class="profile-photo-container mb-4">
                <img src="{{ $user->foto_perfil_url }}" 
                     alt="Profile photo" 
                     class="profile-photo">
                <label for="foto_perfil" class="photo-upload-button">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </label>
            </div>
            <input type="file" id="foto_perfil" name="foto_perfil" class="hidden" accept="image/*">
            
            <div class="text-center">
                <h3 class="text-xl font-bold text-gray-900">{{ $user->getNombreCompletoAttribute() }}</h3>
                <div class="flex items-center justify-center space-x-2 mt-2">
                    <span class="status-badge">
                        {{ $user->rolSistema->nombre ?? 'Usuario' }}
                    </span>
                    @if($user->estudiante)
                        <span class="status-badge bg-blue-500">
                            {{ $user->estudiante->carrera->nombre ?? 'Estudiante' }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <!-- Campos en grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                        Nombre
                    </label>
                    <input type="text" id="nombre" name="nombre" 
                           class="neuromorphic-input w-full"
                           value="{{ old('nombre', $user->nombre) }}" 
                           required autofocus>
                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="app_paterno" class="block text-sm font-medium text-gray-700 mb-2">
                        Apellido Paterno
                    </label>
                    <input type="text" id="app_paterno" name="app_paterno" 
                           class="neuromorphic-input w-full"
                           value="{{ old('app_paterno', $user->app_paterno) }}" 
                           required>
                    @error('app_paterno')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="app_materno" class="block text-sm font-medium text-gray-700 mb-2">
                        Apellido Materno
                    </label>
                    <input type="text" id="app_materno" name="app_materno" 
                           class="neuromorphic-input w-full"
                           value="{{ old('app_materno', $user->app_materno) }}">
                    @error('app_materno')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Correo Electrónico
                </label>
                <input type="email" id="email" name="email" 
                       class="neuromorphic-input w-full"
                       value="{{ old('email', $user->email) }}" 
                       required>
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                    <p class="text-sm text-yellow-800 mb-2">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" 
                            class="text-sm text-orange-600 hover:text-orange-800 font-medium underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>
            @endif

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="neuromorphic-button">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Cambios
                </button>

                @if (session('status') === 'profile-updated')
                    <div class="flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>¡Guardado!</span>
                    </div>
                @endif
            </div>
        </form>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
    </div>
</section>
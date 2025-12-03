<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Contraseña Actual
                </label>
                <input type="password" id="update_password_current_password" name="current_password" 
                       class="neuromorphic-input w-full" autocomplete="current-password">
                @error('current_password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Nueva Contraseña
                </label>
                <input type="password" id="update_password_password" name="password" 
                       class="neuromorphic-input w-full" autocomplete="new-password">
                @error('password', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar Nueva Contraseña
                </label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation" 
                       class="neuromorphic-input w-full" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="neuromorphic-button">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Cambiar Contraseña
            </button>

            @if (session('status') === 'password-updated')
                <div class="flex items-center text-green-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>¡Contraseña actualizada!</span>
                </div>
            @endif
        </div>
    </form>
</section>
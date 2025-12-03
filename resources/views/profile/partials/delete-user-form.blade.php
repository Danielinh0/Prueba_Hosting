<section class="space-y-6">
    <div class="bg-gradient-to-r from-red-50 to-orange-50 p-6 rounded-xl border border-red-200">
        <p class="text-sm text-gray-600 mb-4">
            {{ __('Una vez que su cuenta se elimine, todos sus recursos y datos se eliminarán permanentemente.') }}
        </p>

        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" 
                class="neuromorphic-button neuromorphic-danger-button">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            {{ __('Eliminar Cuenta') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                {{ __('¿Estás seguro de eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 mb-6">
                {{ __('Una vez que su cuenta se elimine, todos sus recursos y datos se eliminarán permanentemente.') }}
            </p>

            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Contraseña') }}
                    </label>
                    <input type="password" id="password" name="password" 
                           class="neuromorphic-input w-full" 
                           placeholder="{{ __('Contraseña') }}">
                    @error('password', 'userDeletion')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="button" x-on:click="$dispatch('close')" 
                            class="px-4 py-2 text-gray-700 hover:text-gray-900">
                        {{ __('Cancelar') }}
                    </button>
                    
                    <button type="submit" class="neuromorphic-button neuromorphic-danger-button">
                        {{ __('Eliminar Cuenta') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</section>
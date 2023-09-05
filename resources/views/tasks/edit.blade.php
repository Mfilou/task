<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('patch')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Tâche:</label>
                <input type="text" name="name" id="name" value="{{ $task->name }}" class="form-input rounded-md shadow-sm w-full" readonly>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea name="description" id="description" class="form-input rounded-md shadow-sm w-full" readonly>{{ $task->description }}</textarea>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">État:</label>
                <select name="status" id="status" class="form-select rounded-md shadow-sm w-full">
                    <option value="en cours" {{ old('status', $task->status) === 'en cours' ? 'selected' : '' }}>En Cours</option>
                    <option value="terminée" {{ old('status', $task->status) === 'terminée' ? 'selected' : '' }}>Terminée</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="assigned_user_id" class="block text-gray-700 text-sm font-bold mb-2">Destinataire:</label>
                <input type="text" name="assigned_user_id" id="assigned_user_id" value="{{ $task->assignedUser ? $task->assignedUser->name : 'Non Affecté' }}" class="form-input rounded-md shadow-sm w-full" readonly>
            </div>
            
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
            
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('tasks.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>


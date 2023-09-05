<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.assign', $task) }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="assigned_users" class="block text-gray-700 text-sm font-bold mb-2">Sélectionnez les utilisateurs à affecter :</label>
                <select name="assigned_users[]" id="assigned_users" multiple class="form-select rounded-md shadow-sm w-full">
                    @foreach($unassignedUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Affecter') }}</x-primary-button>
                <a href="{{ route('tasks.index') }}">{{ __('Annuler') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>

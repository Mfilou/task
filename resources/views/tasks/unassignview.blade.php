<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('tasks.unassign', $task) }}">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="unassigned_user_ids" class="block text-gray-700 text-sm font-bold mb-2">Désaffecter :</label>
                <select name="unassigned_user_ids[]" id="unassigned_user_ids" class="form-select rounded-md shadow-sm w-full" multiple>
                    @foreach($assignedUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Désaffecter') }}</x-primary-button>
                <a href="{{ route('tasks.index') }}">{{ __('Annuler') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>

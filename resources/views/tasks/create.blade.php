<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créer une nouvelle tâche') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-bold mb-2">Nom de la tâche</label>
                        <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" id="description" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-gray-700 font-bold mb-2">État</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500" required>
                            <option value="en cours">En cours</option>
                            <option value="terminée">Terminée</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="assigned_user_ids">Destinataires :</label>
                        <select name="assigned_user_ids[]" id="assigned_user_ids" class="form-control" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex justify-end">
                        <a href="{{ route('tasks.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-full hover:bg-gray-400 focus:outline-none focus:bg-gray-400">Annuler</a>
                        <button type="submit" class="ml-4 px-4 py-2 bg-blue-500 text-gray rounded-full hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

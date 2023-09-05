<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des Tâches') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Bouton pour créer une nouvelle tâche -->
        <div class="mb-4">
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Créer une nouvelle tâche
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($tasks as $task)
                <div class="relative bg-white p-4 border rounded-md shadow">
                    <!-- Contenu de la tâche -->
                    <p class="font-semibold">Tâche: {{ $task->name }}</p>
                    <p>Description: {{ $task->description }}</p>
                    <p>État: <span class="{{ $task->status == 'terminée' ? 'text-green-600' : 'text-red-600' }}">{{ $task->status }}</span></p>
                    <p>Destinataires:</p>
                    <ul>
                        @foreach ($task->assignedUsers as $user)
                            <li>{{ $user->name }}</li>
                        @endforeach
                    </ul>

                    <!-- Bouton de menu (points verticaux) -->
                    <div class="absolute top-0 right-0 p-2">
                        @if ($task->user_id === auth()->id())
                         <x-dropdown>
                            <x-slot name="trigger">
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M6 10a2 2 0 100-4 2 2 0 000 4z" />
                                        <path d="M12 10a2 2 0 100-4 2 2 0 000 4z" />
                                        <path d="M18 10a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                
                                <form method="POST" action="{{ route('tasks.changeStatus', $task->id) }}">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700 focus:outline-none">Changer État</button>
                                </form>
                                
                                <x-dropdown-link :href="route('tasks.assignview', $task)">
                                    Affecter
                                </x-dropdown-link>
                                
                                <!-- Bouton "Désaffecter" -->
                                <x-dropdown-link :href="route('tasks.unassignview', $task)">
                                    Désaffecter
                                </x-dropdown-link>
                                
                                @can('delete', $task)
                                    <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                        @csrf
                                        @method('DELETE')
                                        <x-dropdown-link href="#" onclick="event.preventDefault(); this.closest('form').submit();">Supprimer</x-dropdown-link>
                                    </form>
                                @endcan
                            </x-slot>
                         </x-dropdown>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>


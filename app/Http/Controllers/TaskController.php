<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use App\Models\User;


class TaskController extends Controller
{

    public function index(): View
    {
        //
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        //
            // Récupere tous les users
         $users = User::all();
         return view('tasks.create' ,  compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:en cours,terminée',
        ]);

        // Créez la tâche
        $task = new Task([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'status' => $validatedData['status'],
            'user_id' => auth()->id(), // Utilisateur connecté comme créateur
            
        ]);

        
        $task->save();

        // Attachez les destinataires
        if ($request->has('assigned_user_ids')) {
            $task->users()->attach($request->input('assigned_user_ids'));
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Tâche créée avec succès.');
    }



    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task): View
    {
        if (auth()->id() !== $task->user_id) {
            abort(403); // Accès non autorisé
        }
        $users = User::whereNotIn('id', [$task->user_id, $task->assigned_user_id])->get();
    
        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        //
        // Validate
        $validatedData = $request->validate([
            'status' => ['required', 'in:en cours,terminée'],
        ]);

        // update
        $task->update([
            'status' => $validatedData['status'],
        ]);

        // Vue
        return redirect()->route('tasks.index');

    }

    public function destroy(Task $task): RedirectResponse
    {
        //
        $this->authorize('delete', $task);
        $task->delete();
        return redirect()->route('tasks.index');

    }

    public function assign(Request $request, Task $task)
    {
        $assignedUsers = $request->input('assigned_users');
        $task->assignedUsers()->attach($assignedUsers);

        return redirect()->route('tasks.index')->with('success', 'Utilisateurs affectés avec succès.');
    }

    public function assignView(Task $task)
    {
            // liste des utilisateurs non affectés à la tâche
        $unassignedUsers = User::whereDoesntHave('tasks', function ($query) use ($task) {
            $query->where('task_id', $task->id);
        })->get();

        return view('tasks.assignview', compact('task', 'unassignedUsers'));

    }

    public function unassignview(Task $task)
    {
        $assignedUsers = $task->assignedUsers;

        return view('tasks.unassignview', compact('task', 'assignedUsers'));
    }
    public function unassign(Task $task, Request $request)
    {
        $unassignedUserIds = $request->input('unassigned_user_ids', []);

        // Désaffectez les utilisateurs sélectionnés de la tâche
        $task->assignedUsers()->detach($unassignedUserIds);
    
        return redirect()->route('tasks.index');
    }

    

    
    public function changeStatus($id)
    {
        $task = Task::findOrFail($id);

        // Logique pour passer à l'état suivant (par exemple, de "En Cours" à "Terminée")
        if ($task->status == 'en cours') {
            $task->status = 'terminée';
        } elseif ($task->status == 'terminée') {
            $task->status = 'en cours';
        }

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'État de la tâche mis à jour avec succès.');
    }


}

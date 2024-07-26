<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $tasks = Task::query()
            ->when($search, function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->paginate(5); // Paginate with 5 tasks per page
    
        // Fetch the users for assign_by and assign_to fields
        $assignByIds = collect($tasks->items())->pluck('assign_by')->unique();
        $assignToIds = collect($tasks->items())->pluck('assign_to')->unique();
        $userIds = $assignByIds->merge($assignToIds)->unique();
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');
    
        // Return an Inertia page with the tasks and users data
        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'users' => $users,
        ]);
    }
    
    
    
    
    
    
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return Inertia::render('Tasks/Create', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assign_by' => 'required|exists:users,id',
            'assign_to' => 'required|exists:users,id',
            'dead_line' => 'required|date',
            'description' => 'required|string|max:65535',
            'status' => 'required|in:complete,incomplete',
        ]);

        $task = Task::create([
            'assign_by' => $validated['assign_by'],
            'assign_to' => $validated['assign_to'],
            'dead_line' => $validated['dead_line'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the task by ID, or fail if not found
        $task = Task::findOrFail($id);
    
        // Fetch the user data for the assign_by and assign_to fields
        $userIds = [$task->assign_by, $task->assign_to];
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');
    
        // Return an Inertia page with the task and users data
        return Inertia::render('Tasks/Show', [
            'task' => $task,
            'users' => $users,
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::all(); // Fetch all users for the dropdown
        return Inertia::render('Tasks/Edit', ['task' => $task, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
    
        $validated = $request->validate([
            'assign_by' => 'required|exists:users,id',
            'assign_to' => 'required|exists:users,id',
            'dead_line' => 'required|date',
            'description' => 'required|string|max:65535',
            'status' => 'required|in:complete,incomplete',
        ]);
    
        $task->update([
            'assign_by' => $validated['assign_by'],
            'assign_to' => $validated['assign_to'],
            'dead_line' => $validated['dead_line'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);
    
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}

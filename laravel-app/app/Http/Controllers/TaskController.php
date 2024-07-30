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
    
        // Return an Inertia page with the tasks data
        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dead_line' => 'required|date',
            'description' => 'required|string|max:65535',
            'status' => 'required|in:complete,incomplete',
        ]);

        $task = Task::create([
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
    
        // Return an Inertia page with the task data
        return Inertia::render('Tasks/Show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', ['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
    
        $validated = $request->validate([
            'dead_line' => 'required|date',
            'description' => 'required|string|max:65535',
            'status' => 'required|in:complete,incomplete',
        ]);
    
        $task->update([
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

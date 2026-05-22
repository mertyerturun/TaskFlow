<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with(['project', 'user'])->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $developers = User::all();
        return view('admin.tasks.create', compact('projects', 'developers'));
    }

    public function store(Request $request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tasks', 'public');
        }

        $task = new Task();
        $task->project_id = $request->project_id;
        $task->user_id = $request->user_id;
        $task->title = $request->title;
        $task->detail = $request->detail;
        $task->image = $imagePath;
        $task->status = $request->status ?? 'Active';
        $task->save();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('admin.tasks.show', compact('task'));
    }
    public function edit(Task $task)
    {
        $projects = Project::all();
        $developers = User::all();
        return view('admin.tasks.edit', compact('task', 'projects', 'developers'));
    }

    public function update(Request $request, Task $task)
    {
        $task->project_id = $request->project_id;
        $task->user_id = $request->user_id;
        $task->title = $request->title;
        $task->detail = $request->detail;

        if ($request->hasFile('image')) {
            $task->image = $request->file('image')->store('tasks', 'public');
        }

        $task->status = $request->status;
        $task->save();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}

@extends('layouts.app')

@section('title', 'Task List')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-kanban me-2"></i>Task & Project Management</h2>
        @if(Auth::user()->hasAnyRole(['admin', 'manager']))
            <a href="{{ route('tasks.create') }}" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Add New Task
            </a>
        @endif
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-0 bg-primary text-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Total Tasks</h6>
                        <h2 class="display-6 mb-0 fw-bold">{{ $tasks->count() }}</h2>
                    </div>
                    <i class="bi bi-list-task display-5 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 bg-success text-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Active Tasks</h6>
                        <h2 class="display-6 mb-0 fw-bold">{{ $tasks->where('status', 'Active')->count() }}</h2>
                    </div>
                    <i class="bi bi-check2-circle display-5 opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 bg-danger text-white shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase mb-1 opacity-75">Passive Tasks</h6>
                        <h2 class="display-6 mb-0 fw-bold">{{ $tasks->where('status', 'Passive')->count() }}</h2>
                    </div>
                    <i class="bi bi-x-circle display-5 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" id="taskSearch" class="form-control bg-light border-start-0 ps-0" placeholder="Search tasks by title...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select id="statusFilter" class="form-select bg-light">
                        <option value="all">All Statuses</option>
                        <option value="Active">Active Only</option>
                        <option value="Passive">Passive Only</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                <tr>
                    <th>#ID</th>
                    <th>Image</th>
                    <th>Task Title</th>
                    <th>Project</th>
                    <th>Priority</th>
                    <th>Assigned Developer</th>
                    <th>Status</th>
                    <th width="240" class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody id="taskTableBody">
                @forelse($tasks as $task)
                    <tr class="task-row" data-status="{{ $task->status }}">
                        <td>{{ $task->id }}</td>
                        <td>
                            @if($task->image)
                                <img src="{{ asset('storage/' . $task->image) }}" width="45" height="45" class="rounded-circle object-fit-cover shadow-sm">
                            @else
                                <span class="badge bg-light text-secondary border"><i class="bi bi-file-earmark-slash me-1"></i>No File</span>
                            @endif
                        </td>
                        <td class="task-title-cell"><strong>{{ $task->title }}</strong></td>
                        <td><span class="badge bg-info text-dark shadow-sm"><i class="bi bi-folder2 me-1"></i>{{ $task->project->name }}</span></td>

                        <td>
                            @if($task->id % 3 == 0)
                                <span class="badge bg-light-danger text-danger border border-danger rounded-pill px-2">High</span>
                            @elseif($task->id % 3 == 1)
                                <span class="badge bg-light-warning text-warning border border-warning rounded-pill px-2">Medium</span>
                            @else
                                <span class="badge bg-light-success text-success border border-success rounded-pill px-2">Low</span>
                            @endif
                        </td>

                        <td><i class="bi bi-person me-1 text-muted"></i>{{ $task->user->name ?? 'Unassigned' }}</td>
                        <td>
                            <span class="badge rounded-pill {{ $task->status == 'Active' ? 'bg-success' : 'bg-danger' }} px-3">
                                {{ $task->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-sm btn-info text-white shadow-sm">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                @if(Auth::user()->hasAnyRole(['admin', 'manager']))
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning shadow-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger shadow-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="noTasksRow">
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox display-4 d-block mb-2 opacity-50"></i>
                            No tasks have been defined in the system yet.
                        </td>
                    </tr>
                @endforelse

                <tr id="noMatchRow" style="display: none;">
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-search display-4 d-block mb-2 opacity-50"></i>
                        No matching tasks found.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('taskSearch');
        const statusFilter = document.getElementById('statusFilter');
        const taskRows = document.querySelectorAll('.task-row');
        const noMatchRow = document.getElementById('noMatchRow');

        function filterTasks() {
            const searchText = searchInput.value.toLowerCase();
            const selectedStatus = statusFilter.value;
            let visibleCount = 0;

            taskRows.forEach(row => {
                const title = row.querySelector('.task-title-cell').textContent.toLowerCase();
                const status = row.getAttribute('data-status');

                const matchesSearch = title.includes(searchText);
                const matchesStatus = (selectedStatus === 'all' || status === selectedStatus);

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Eğer hiçbir satır eşleşmediyse "Bulunamadı" uyarısını göster
            if (taskRows.length > 0) {
                noMatchRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        searchInput.addEventListener('input', filterTasks);
        statusFilter.addEventListener('change', filterTasks);
    </script>
@endsection

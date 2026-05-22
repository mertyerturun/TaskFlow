@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="card shadow-sm max-width-800 mx-auto border-0">
        <div class="card-header bg-info text-white py-3">
            <h4 class="mb-0"><i class="bi bi-card-heading me-2"></i>Task Details Log</h4>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-4 text-center mb-4">
                    <h5 class="text-muted mb-3">Task Attachment</h5>
                    @if($task->image)
                        <img src="{{ asset('storage/' . $task->image) }}" class="img-fluid img-thumbnail rounded shadow-sm">
                    @else
                        <div class="bg-light border text-muted py-5 rounded shadow-inner">
                            <i class="bi bi-image display-4 d-block mb-2 opacity-50"></i>
                            No Image
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="d-flex justify-content-between align-items-start">
                        <h2 class="text-primary mb-1">{{ $task->title }}</h2>
                    </div>
                    <p class="text-muted mb-3"><strong>Project:</strong> <i class="bi bi-folder2-open ms-1"></i> {{ $task->project->name }}</p>
                    <hr>
                    <h5>Task Description:</h5>
                    <p class="p-3 bg-light border rounded text-secondary" style="white-space: pre-wrap;">{{ $task->detail ?? 'No description provided.' }}</p>
                    <hr>
                    <div class="row bg-light mx-0 p-3 rounded border">
                        <div class="col-6">
                            <i class="bi bi-person-badge text-muted me-1"></i><strong>Assigned To:</strong>
                            <span class="d-block text-secondary mt-1">{{ $task->user->name ?? 'Unassigned' }}</span>
                        </div>
                        <div class="col-6">
                            <i class="bi bi-toggle-on text-muted me-1"></i><strong>Status:</strong>
                            <span class="d-block mt-1">
                            <span class="badge {{ $task->status == 'Active' ? 'bg-success' : 'bg-danger' }} px-3">{{ $task->status }}</span>
                        </span>
                        </div>
                    </div>

                    <div class="mt-4 text-end text-muted small">
                        <i class="bi bi-clock-history me-1"></i>Created {{ $task->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white text-end py-3 border-top-0">
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary shadow-sm">
                <i class="bi bi-arrow-left-circle me-1"></i> Back to List
            </a>
        </div>
    </div>
@endsection

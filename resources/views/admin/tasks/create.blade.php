@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Create New Task</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.tasks.form')

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Task</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

<div class="mb-3">
    <label class="form-label">Associated Project</label>
    <select name="project_id" class="form-select" required>
        @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id ?? '') == $project->id ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Assign to Developer</label>
    <select name="user_id" class="form-select">
        <option value="">-- Unassigned --</option>
        @foreach($developers as $dev)
            <option value="{{ $dev->id }}" {{ old('user_id', $task->user_id ?? '') == $dev->id ? 'selected' : '' }}>
                {{ $dev->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Task Title</label>
    <input type="text" name="title" class="form-control" value="{{ old('title', $task->title ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Task Details</label>
    <textarea name="detail" class="form-control" rows="5">{{ old('detail', $task->detail ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Task Image / Attachment</label>
    <input type="file" name="image" class="form-control">
    @if(!empty($task?->image))
        <div class="mt-2">
            <img src="{{ asset('storage/' . $task->image) }}" width="100" class="img-thumbnail">
        </div>
    @endif
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        <option value="Active" {{ old('status', $task->status ?? '') == 'Active' ? 'selected' : '' }}>Active</option>
        <option value="Passive" {{ old('status', $task->status ?? '') == 'Passive' ? 'selected' : '' }}>Passive</option>
    </select>
</div>

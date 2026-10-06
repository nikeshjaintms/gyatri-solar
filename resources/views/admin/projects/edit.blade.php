@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-pencil-square"></i></span>
        Edit Solar Project
    </h1>
    <a href="{{ route('projects.show', $project) }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to Details
    </a>
</div>

{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Edit Project: {{ $project->project_name }}</h6>
    </div>

    <form action="{{ route('projects.update', $project) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card-body">
            @include('admin.projects._form')
        </div>

        <div class="form-footer">
            <a href="{{ route('projects.show', $project) }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Update Project
            </button>
        </div>
    </form>
</div>

@endsection
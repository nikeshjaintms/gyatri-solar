@extends('layouts.admin')

@section('content')

{{-- ── Page Header ── --}}
<div class="form-page-header">
    <h1 class="form-page-title">
        <span class="title-icon"><i class="bi bi-sun"></i></span>
        Add New Solar Project
    </h1>
    <a href="{{ route('projects.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Back to List
    </a>
</div>

{{-- ── Form Card ── --}}
<div class="form-card">
    <div class="form-card-header">
        <div class="section-dot"></div>
        <h6>Project Information</h6>
    </div>

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="form-card-body">
            @include('admin.projects._form')
        </div>

        <div class="form-footer">
            <a href="{{ route('projects.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Cancel
            </a>
            <button type="submit" class="btn-save">
                <i class="bi bi-check-lg"></i> Save Project
            </button>
        </div>
    </form>
</div>

@endsection
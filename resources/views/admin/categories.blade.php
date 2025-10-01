@extends('layouts.app')

@section('title', __('Category Management'))

@push('styles')
<style>
    .pagination {
        font-size: 0.9rem;
    }
    .pagination .page-link {
        padding: 0.25rem 0.5rem;
    }
    .pagination .page-item .page-link {
        border-radius: 0.2rem;
        margin: 0 2px;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Category Management') }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('Back to Dashboard') }}
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">{{ __('All Categories') }}</div>
        <div class="card-body">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> {{ __('Add New Category') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-primary me-2"><i class="bi bi-pencil"></i> Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', __('Ingredient Management'))

@push('styles')
<style>
    /* Fix for oversized pagination buttons */
    .pagination {
        font-size: 0.9rem;
    }
    .pagination .page-link {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Ingredient Management') }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('Back to Dashboard') }}
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <i class="bi bi-list-ul me-2"></i>{{ __('All Ingredients') }}
        </div>
        <div class="card-body">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div></div>
                <a href="{{ route('admin.ingredients.create') }}" class="btn btn-warning">
                    <i class="bi bi-plus-circle"></i> {{ __('Add New Ingredient') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ingredients as $ingredient)
                        <tr>
                            <td>{{ $ingredient->id }}</td>
                            <td>{{ $ingredient->name }}</td>
                            <td>{{ $ingredient->category }}</td>
                            <td>
                                <a href="{{ route('admin.ingredients.edit', $ingredient->id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form class="d-inline" method="POST" action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" onsubmit="return confirm('Are you sure you want to delete this ingredient?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $ingredients->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('Ingredient Management') }}</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h3>{{ __('All Ingredients') }}</h3>
                <a href="{{ route('admin.ingredients.create') }}" class="btn btn-dark">
                    {{ __('Add New Ingredient') }}
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
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
                                <a href="{{ route('admin.ingredients.edit', $ingredient->id) }}" class="btn btn-sm btn-primary me-2">Edit</a>
                                <form class="d-inline" method="POST" action="{{ route('admin.ingredients.destroy', $ingredient->id) }}" onsubmit="return confirm('Are you sure you want to delete this ingredient?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
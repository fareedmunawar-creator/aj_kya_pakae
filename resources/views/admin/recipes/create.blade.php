@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.recipes.index') }}">Recipe Management</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create Recipe</li>
                </ol>
            </nav>
            <h1 class="h2 mb-0">Create New Recipe</h1>
        </div>
    </div>

    <!-- Create Recipe Form -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Recipe Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach(\App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="instructions" class="form-label">Instructions</label>
                    <textarea class="form-control @error('instructions') is-invalid @enderror" 
                              id="instructions" name="instructions" rows="6">{{ old('instructions') }}</textarea>
                    @error('instructions')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ingredients</label>
                    <div class="ingredients-container">
                        <div class="row mb-2 ingredient-row">
                            <div class="col-md-5">
                                <select class="form-select" name="ingredients[]" required>
                                    <option value="">Select Ingredient</option>
                                    @foreach(\App\Models\Ingredient::all() as $ingredient)
                                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="quantities[]" placeholder="Quantity" step="0.01">
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="units[]" placeholder="Unit">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-ingredient">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-2" id="add-ingredient">
                        <i class="bi bi-plus-circle me-2"></i>Add Ingredient
                    </button>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label">Recipe Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.recipes.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Create Recipe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add ingredient row
        document.getElementById('add-ingredient').addEventListener('click', function() {
            const container = document.querySelector('.ingredients-container');
            const newRow = document.querySelector('.ingredient-row').cloneNode(true);
            
            // Clear input values
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelector('select').selectedIndex = 0;
            
            // Add event listener to remove button
            newRow.querySelector('.remove-ingredient').addEventListener('click', function() {
                this.closest('.ingredient-row').remove();
            });
            
            container.appendChild(newRow);
        });
        
        // Remove ingredient row
        document.querySelectorAll('.remove-ingredient').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.ingredient-row').remove();
            });
        });
    });
</script>
@endpush
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">
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
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Create Recipe Form -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h3 mb-0 text-primary">
                        <i class="bi bi-journal-plus me-2"></i>Create New Recipe
                    </h2>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold">Recipe Title</label>
                                    <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                        id="title" name="title" value="{{ old('title') }}" required autofocus>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="category_id" class="form-label fw-bold">Category</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
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
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                    id="description" name="description" rows="3" placeholder="Describe your recipe in a few sentences">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="cooking_time" class="form-label fw-bold">Cooking Time (minutes)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                    <input type="number" class="form-control @error('cooking_time') is-invalid @enderror" 
                                        id="cooking_time" name="cooking_time" value="{{ old('cooking_time') }}" required>
                                </div>
                                @error('cooking_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="difficulty" class="form-label fw-bold">Difficulty</label>
                                <select class="form-select @error('difficulty') is-invalid @enderror" 
                                        id="difficulty" name="difficulty">
                                    <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                    <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                                </select>
                                @error('difficulty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="form-label fw-bold">Recipe Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                id="image" name="image">
                            <div class="form-text">Upload a high-quality image of your finished recipe (recommended size: 1200x800px)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Ingredients</label>
                            <div id="ingredients-container" class="mb-3">
                                <div class="ingredient-row row g-2 mb-2 align-items-center">
                                    <div class="col-md-5">
                                        <select class="form-select @error('ingredients.*') is-invalid @enderror" name="ingredients[]" required>
                                            <option value="">Select Ingredient</option>
                                            @foreach(\App\Models\Ingredient::all() as $ingredient)
                                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" class="form-control" name="quantities[]" placeholder="Quantity" step="0.01">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="units[]" placeholder="Unit">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-ingredient" style="display: none;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-ingredient">
                                <i class="bi bi-plus-circle me-1"></i>Add Ingredient
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <label for="instructions" class="form-label fw-bold">Cooking Instructions</label>
                            <textarea class="form-control @error('instructions') is-invalid @enderror" 
                                    id="instructions" name="instructions" rows="6" placeholder="Enter step-by-step instructions. Separate each step with a new line.">{{ old('instructions') }}</textarea>
                            <div class="form-text">Enter each step on a new line. Be clear and detailed with your instructions.</div>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end mt-5">
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
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addIngredientBtn = document.getElementById('add-ingredient');
        const ingredientsContainer = document.getElementById('ingredients-container');
        
        // Show remove button for all rows except the first one initially
        updateRemoveButtons();
        
        addIngredientBtn.addEventListener('click', function() {
            const ingredientRow = document.querySelector('.ingredient-row').cloneNode(true);
            const inputs = ingredientRow.querySelectorAll('input, select');
            inputs.forEach(input => input.value = '');
            
            // Show the remove button for this new row
            const removeBtn = ingredientRow.querySelector('.remove-ingredient');
            removeBtn.style.display = 'block';
            
            // Add event listener to the remove button
            removeBtn.addEventListener('click', function() {
                ingredientRow.remove();
                updateRemoveButtons();
            });
            
            ingredientsContainer.appendChild(ingredientRow);
            updateRemoveButtons();
        });
        
        // Add event listeners to existing remove buttons
        document.querySelectorAll('.remove-ingredient').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.ingredient-row').remove();
                updateRemoveButtons();
            });
        });
        
        // Function to update remove buttons visibility
        function updateRemoveButtons() {
            const rows = document.querySelectorAll('.ingredient-row');
            if (rows.length === 1) {
                rows[0].querySelector('.remove-ingredient').style.display = 'none';
            } else {
                rows.forEach((row, index) => {
                    row.querySelector('.remove-ingredient').style.display = 'block';
                });
            }
        }
    });
</script>
@endpush
@endsection
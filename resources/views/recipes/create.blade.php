@extends('layouts.app')

@section('title', __('messages.recipes'))

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">{{ __('messages.recipes') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Create New Recipe') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h3 mb-0 text-primary">
                        <i class="bi bi-journal-plus me-2"></i>{{ __('Create New Recipe') }}
                    </h2>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold">{{ __('Recipe Title') }}</label>
                                    <input id="title" type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-4">
                                    <label for="category_id" class="form-label fw-bold">{{ __('Category') }}</label>
                                    <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Describe your recipe in a few sentences">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="cooking_time" class="form-label fw-bold">{{ __('Cooking Time (minutes)') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                    <input id="cooking_time" type="number" class="form-control @error('cooking_time') is-invalid @enderror" name="cooking_time" value="{{ old('cooking_time') }}" required>
                                </div>
                                @error('cooking_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="difficulty" class="form-label fw-bold">{{ __('Difficulty') }}</label>
                                <select id="difficulty" name="difficulty" class="form-select @error('difficulty') is-invalid @enderror">
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
                            <label for="image" class="form-label fw-bold">{{ __('Recipe Image') }}</label>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            <div class="form-text">Upload a high-quality image of your finished recipe (recommended size: 1200x800px)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('Ingredients') }}</label>
                            <div id="ingredients-container" class="mb-3">
                                <div class="ingredient-row row g-2 mb-2 align-items-center">
                                    <div class="col-md-5">
                                        <select name="ingredients[]" class="form-select @error('ingredients.*') is-invalid @enderror" placeholder="Select ingredient">
                                            <option value="">Select Ingredient</option>
                                            @foreach($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input name="quantities[]" placeholder="Quantity" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <input name="units[]" placeholder="Unit" class="form-control">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-ingredient" style="display: none;">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-ingredient" class="btn btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i> Add Ingredient
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <label for="instructions" class="form-label fw-bold">{{ __('Cooking Instructions') }}</label>
                            <textarea id="instructions" name="instructions" class="form-control @error('instructions') is-invalid @enderror" rows="6" placeholder="Enter step-by-step instructions. Separate each step with a new line.">{{ old('instructions') }}</textarea>
                            <div class="form-text">Enter each step on a new line. Be clear and detailed with your instructions.</div>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x-circle me-1"></i>{{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>{{ __('Create Recipe') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
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
@endsection
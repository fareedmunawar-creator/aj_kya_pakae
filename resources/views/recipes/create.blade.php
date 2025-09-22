@extends('layouts.app')

@section('title', __('messages.recipes'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2>{{ __('Create New Recipe') }}</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Recipe Title') }}</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">{{ __('Category') }}</label>
                            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="cooking_time" class="form-label">{{ __('Cooking Time (minutes)') }}</label>
                            <input id="cooking_time" type="number" class="form-control @error('cooking_time') is-invalid @enderror" name="cooking_time" value="{{ old('cooking_time') }}" required>
                            @error('cooking_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="difficulty" class="form-label">{{ __('Difficulty') }}</label>
                            <select id="difficulty" name="difficulty" class="form-select @error('difficulty') is-invalid @enderror">
                                <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                            @error('difficulty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ __('Recipe Image') }}</label>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('Ingredients') }}</label>
                            <div id="ingredients-container">
                                <div class="ingredient-row row mb-2">
                                    <div class="col-md-6">
                                        <select name="ingredients[]" class="form-select @error('ingredients.*') is-invalid @enderror">
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
                                </div>
                            </div>
                            <button type="button" id="add-ingredient" class="btn btn-secondary mt-2">+ Add Ingredient</button>
                        </div>
                        
                        <div class="mb-3">
                            <label for="instructions" class="form-label">{{ __('Cooking Instructions') }}</label>
                            <textarea id="instructions" name="instructions" class="form-control @error('instructions') is-invalid @enderror" rows="6">{{ old('instructions') }}</textarea>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('recipes.index') }}" class="btn btn-outline-secondary me-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Create Recipe') }}
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
        
        addIngredientBtn.addEventListener('click', function() {
            const ingredientRow = document.querySelector('.ingredient-row').cloneNode(true);
            const inputs = ingredientRow.querySelectorAll('input, select');
            inputs.forEach(input => input.value = '');
            ingredientsContainer.appendChild(ingredientRow);
        });
    });
</script>
@endsection
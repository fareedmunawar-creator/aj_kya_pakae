@extends('layouts.app')

@section('title', __('Edit Meal Plan'))

@section('content')
<div class="container py-4 fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold">{{ __('Edit Meal Plan') }}</h1>
    </div>

    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('mealplanner.update', $mealPlan->id) }}" class="form-elegant">
                @csrf
                @method('PUT')
                
                @if(!$day && !$mealType)
                <!-- Full meal plan edit -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="name" class="form-label">{{ __('Meal Plan Name') }}</label>
                            <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $mealPlan->name) }}" required autofocus />
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                            <input id="start_date" class="form-control" type="date" name="start_date" value="{{ old('start_date', $mealPlan->start_date->format('Y-m-d')) }}" required />
                            @error('start_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-4">
                            <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                            <input id="end_date" class="form-control" type="date" name="end_date" value="{{ old('end_date', $mealPlan->end_date->format('Y-m-d')) }}" required />
                            @error('end_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <h3 class="section-title mb-4">{{ __('Edit Recipes for Your Meal Plan') }}</h3>
                
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                    @foreach($days as $dayKey => $dayName)
                        <div class="col slide-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                            <div class="card h-100 meal-plan-card">
                                <div class="card-header bg-white py-3">
                                    <h5 class="mb-0 meal-plan-day">{{ $dayName }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="meal-type-badge meal-type-breakfast mb-2">{{ __('Breakfast') }}</label>
                                        <select name="meals[{{ $dayKey }}][breakfast]" class="form-select">
                                            <option value="">{{ __('Select Recipe') }}</option>
                                            @foreach($recipes as $recipe)
                                                <option value="{{ $recipe->id }}" {{ isset($selectedRecipes[$dayKey]['breakfast']) && $selectedRecipes[$dayKey]['breakfast'] == $recipe->id ? 'selected' : '' }}>{{ $recipe->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="meal-type-badge meal-type-lunch mb-2">{{ __('Lunch') }}</label>
                                        <select name="meals[{{ $dayKey }}][lunch]" class="form-select">
                                            <option value="">{{ __('Select Recipe') }}</option>
                                            @foreach($recipes as $recipe)
                                                <option value="{{ $recipe->id }}" {{ isset($selectedRecipes[$dayKey]['lunch']) && $selectedRecipes[$dayKey]['lunch'] == $recipe->id ? 'selected' : '' }}>{{ $recipe->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="meal-type-badge meal-type-dinner mb-2">{{ __('Dinner') }}</label>
                                        <select name="meals[{{ $dayKey }}][dinner]" class="form-select">
                                            <option value="">{{ __('Select Recipe') }}</option>
                                            @foreach($recipes as $recipe)
                                                <option value="{{ $recipe->id }}" {{ isset($selectedRecipes[$dayKey]['dinner']) && $selectedRecipes[$dayKey]['dinner'] == $recipe->id ? 'selected' : '' }}>{{ $recipe->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="meal-type-badge meal-type-snack mb-2">{{ __('Snack') }}</label>
                                        <select name="meals[{{ $dayKey }}][snack]" class="form-select">
                                            <option value="">{{ __('Select Recipe') }}</option>
                                            @foreach($recipes as $recipe)
                                                <option value="{{ $recipe->id }}" {{ isset($selectedRecipes[$dayKey]['snack']) && $selectedRecipes[$dayKey]['snack'] == $recipe->id ? 'selected' : '' }}>{{ $recipe->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <!-- Single meal edit -->
                <div class="card meal-plan-card mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 meal-plan-day">{{ $days[$day] ?? $day }} - {{ ucfirst($mealType) }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="meal-type-badge meal-type-{{ $mealType }} mb-2">{{ __('Select Recipe for ' . ucfirst($mealType)) }}</label>
                            <select name="meals[{{ $day }}][{{ $mealType }}]" class="form-select">
                                <option value="">{{ __('Select Recipe') }}</option>
                                @foreach($recipes as $recipe)
                                    <option value="{{ $recipe->id }}" {{ isset($selectedRecipes[$day][$mealType]) && $selectedRecipes[$day][$mealType] == $recipe->id ? 'selected' : '' }}>{{ $recipe->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('mealplanner.show', $mealPlan->id) }}" class="btn btn-outline-secondary me-2">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Update Meal Plan') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
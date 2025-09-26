@extends('layouts.app')

@section('title', __('Create Meal Plan'))

@section('content')
<div class="container py-4">
    <!-- Page Header with Breadcrumb -->
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mealplanner.index') }}">{{ __('Meal Planner') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Create Meal Plan') }}</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold">{{ __('Create Meal Plan') }}</h1>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('meal-plans.store') }}">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Meal Plan Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">{{ __('Start Date') }}</label>
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <h3 class="fw-bold fs-4 mb-3">
                        <i class="bi bi-calendar-check me-2"></i>{{ __('Select Recipes for Your Meal Plan') }}
                    </h3>
                    
                    <div class="row g-4">
                        @foreach($days as $day => $dayName)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">{{ $dayName }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <span class="badge bg-primary me-2">{{ __('Breakfast') }}</span>
                                            </label>
                                            <select name="meals[{{ $day }}][breakfast]" class="form-select">
                                                <option value="">{{ __('Select Recipe') }}</option>
                                                @foreach($recipes as $recipe)
                                                    <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">
                                                <span class="badge bg-success me-2">{{ __('Lunch') }}</span>
                                            </label>
                                            <select name="meals[{{ $day }}][lunch]" class="form-select">
                                                <option value="">{{ __('Select Recipe') }}</option>
                                                @foreach($recipes as $recipe)
                                                    <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div>
                                            <label class="form-label">
                                                <span class="badge bg-info me-2">{{ __('Dinner') }}</span>
                                            </label>
                                            <select name="meals[{{ $day }}][dinner]" class="form-select">
                                                <option value="">{{ __('Select Recipe') }}</option>
                                                @foreach($recipes as $recipe)
                                                    <option value="{{ $recipe->id }}">{{ $recipe->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('mealplanner.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i>{{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>{{ __('Create Meal Plan') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
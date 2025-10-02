@extends('layouts.app')

@section('title', $mealPlan->name)

@section('content')
<div class="container py-4 fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold">{{ $mealPlan->name }}</h1>
        <div>
            <a href="{{ route('mealplanner.shopping-list', $mealPlan->id) }}" class="btn btn-gold me-2">
                <i class="bi bi-cart me-1"></i> {{ __('Shopping List') }}
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4 gradient-primary text-white">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="card-title text-white">{{ __('Plan Details') }}</h3>
                    <p class="mb-0">
                        <i class="bi bi-calendar-range me-1"></i>
                        {{ __('From') }} {{ $mealPlan->start_date->format('M d, Y') }} {{ __('to') }} {{ $mealPlan->end_date->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @foreach($mealDays as $day => $meals)
            <div class="col slide-in-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="card h-100 shadow-sm meal-plan-card">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-capitalize meal-plan-day">{{ $day }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title">
                                    <span class="meal-type-badge meal-type-breakfast">{{ __('Breakfast') }}</span>
                                </h5>
                                <a href="{{ route('mealplanner.edit', ['id' => $mealPlan->id, 'day' => $day, 'meal_type' => 'breakfast']) }}" 
                                   class="meal-edit-btn" title="{{ __('Edit Breakfast') }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                            @if(isset($meals['breakfast']))
                                <div class="d-flex align-items-center mt-2 hover-lift">
                                    <div class="flex-shrink-0">
                                        @if($meals['breakfast']->image_path)
                                            <img class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['breakfast']->image_path) }}" 
                                                alt="{{ $meals['breakfast']->title }}">
                                        @else
                                            <div class="rounded-circle bg-primary-light d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-cup-hot text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['breakfast']->id) }}" class="text-decoration-none fw-medium">
                                            {{ $meals['breakfast']->title }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted fst-italic">{{ __('No recipe selected') }}</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title">
                                    <span class="meal-type-badge meal-type-lunch">{{ __('Lunch') }}</span>
                                </h5>
                                <a href="{{ route('mealplanner.edit', ['id' => $mealPlan->id, 'day' => $day, 'meal_type' => 'lunch']) }}" 
                                   class="meal-edit-btn" title="{{ __('Edit Lunch') }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                            @if(isset($meals['lunch']))
                                <div class="d-flex align-items-center mt-2 hover-lift">
                                    <div class="flex-shrink-0">
                                        @if($meals['lunch']->image_path)
                                            <img class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['lunch']->image_path) }}" 
                                                alt="{{ $meals['lunch']->title }}">
                                        @else
                                            <div class="rounded-circle bg-primary-light d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-cup-hot text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['lunch']->id) }}" class="text-decoration-none fw-medium">
                                            {{ $meals['lunch']->title }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted fst-italic">{{ __('No recipe selected') }}</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title">
                                    <span class="meal-type-badge meal-type-dinner">{{ __('Dinner') }}</span>
                                </h5>
                                <a href="{{ route('mealplanner.edit', ['id' => $mealPlan->id, 'day' => $day, 'meal_type' => 'dinner']) }}" 
                                   class="meal-edit-btn" title="{{ __('Edit Dinner') }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                            @if(isset($meals['dinner']))
                                <div class="d-flex align-items-center mt-2 hover-lift">
                                    <div class="flex-shrink-0">
                                        @if($meals['dinner']->image_path)
                                            <img class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['dinner']->image_path) }}" 
                                                alt="{{ $meals['dinner']->title }}">
                                        @else
                                            <div class="rounded-circle bg-primary-light d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-cup-hot text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['dinner']->id) }}" class="text-decoration-none fw-medium">
                                            {{ $meals['dinner']->title }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted fst-italic">{{ __('No recipe selected') }}</p>
                            @endif
                        </div>

                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title">
                                    <span class="meal-type-badge meal-type-snack">{{ __('Snack') }}</span>
                                </h5>
                                <a href="{{ route('mealplanner.edit', ['id' => $mealPlan->id, 'day' => $day, 'meal_type' => 'snack']) }}" 
                                   class="meal-edit-btn" title="{{ __('Edit Snack') }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </div>
                            @if(isset($meals['snack']))
                                <div class="d-flex align-items-center mt-2 hover-lift">
                                    <div class="flex-shrink-0">
                                        @if($meals['snack']->image_path)
                                            <img class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['snack']->image_path) }}" 
                                                alt="{{ $meals['snack']->title }}">
                                        @else
                                            <div class="rounded-circle bg-primary-light d-flex align-items-center justify-content-center shadow-sm" 
                                                style="width: 50px; height: 50px;">
                                                <i class="bi bi-cup-hot text-primary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['snack']->id) }}" class="text-decoration-none fw-medium">
                                            {{ $meals['snack']->title }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted fst-italic">{{ __('No recipe selected') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
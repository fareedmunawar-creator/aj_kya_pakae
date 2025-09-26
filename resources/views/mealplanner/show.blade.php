@extends('layouts.app')

@section('title', $mealPlan->name)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ $mealPlan->name }}</h1>
        <div>
            <a href="{{ route('mealplanner.edit', $mealPlan->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i> {{ __('Edit Plan') }}
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="card-title">{{ __('Plan Details') }}</h3>
                    <p class="text-muted">
                        <i class="bi bi-calendar-range me-1"></i>
                        {{ __('From') }} {{ $mealPlan->start_date->format('M d, Y') }} {{ __('to') }} {{ $mealPlan->end_date->format('M d, Y') }}
                    </p>
                </div>
                <div>
                    <a href="{{ route('mealplanner.shopping-list', $mealPlan->id) }}" class="btn btn-success">
                        <i class="bi bi-cart me-1"></i> {{ __('Generate Shopping List') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
        @foreach($mealDays as $day => $meals)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">{{ $dayNames[$day] }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="card-title text-primary">
                                <i class="bi bi-sunrise me-2"></i>{{ __('Breakfast') }}
                            </h5>
                            @if(isset($meals['breakfast']))
                                <div class="d-flex align-items-center mt-2">
                                    <div class="flex-shrink-0">
                                        @if($meals['breakfast']->image_path)
                                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['breakfast']->image_path) }}" 
                                                alt="{{ $meals['breakfast']->title }}">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-egg-fried text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['breakfast']->id) }}" class="text-decoration-none">
                                            {{ $meals['breakfast']->title }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted fst-italic">{{ __('No recipe selected') }}</p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h5 class="card-title text-primary">
                                <i class="bi bi-sun me-2"></i>{{ __('Lunch') }}
                            </h5>
                            @if(isset($meals['lunch']))
                                <div class="d-flex align-items-center mt-2">
                                    <div class="flex-shrink-0">
                                        @if($meals['lunch']->image_path)
                                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['lunch']->image_path) }}" 
                                                alt="{{ $meals['lunch']->title }}">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-cup-hot text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['lunch']->id) }}" class="text-decoration-none">
                                            {{ $meals['lunch']->title }}
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted fst-italic">{{ __('No recipe selected') }}</p>
                            @endif
                        </div>

                        <div>
                            <h5 class="card-title text-primary">
                                <i class="bi bi-moon me-2"></i>{{ __('Dinner') }}
                            </h5>
                            @if(isset($meals['dinner']))
                                <div class="d-flex align-items-center mt-2">
                                    <div class="flex-shrink-0">
                                        @if($meals['dinner']->image_path)
                                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;" 
                                                src="{{ asset('storage/' . $meals['dinner']->image_path) }}" 
                                                alt="{{ $meals['dinner']->title }}">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" 
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-egg text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('recipes.show', $meals['dinner']->id) }}" class="text-decoration-none">
                                            {{ $meals['dinner']->title }}
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
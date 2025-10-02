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

    <div class="card shadow-lg mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">{{ __('Meal Plan Schedule') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('Day') }}</th>
                            <th>{{ __('Breakfast') }}</th>
                            <th>{{ __('Lunch') }}</th>
                            <th>{{ __('Dinner') }}</th>
                            <th>{{ __('Snack') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($days as $day => $dayName)
                            <tr>
                                <td class="fw-bold text-capitalize">{{ $dayName }}</td>
                                @foreach($mealTypes as $mealType)
                                    <td>
                                        @if(isset($mealDays[$day][$mealType]))
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    @if(isset($mealDays[$day][$mealType]->getFirstMediaUrl))
                                                        <img src="{{ $mealDays[$day][$mealType]->getFirstMediaUrl() }}" 
                                                            alt="{{ $mealDays[$day][$mealType]->title }}" 
                                                            class="rounded" width="40" height="40" style="object-fit: cover;">
                                                    @elseif($mealDays[$day][$mealType]->image_path)
                                                        <img src="{{ asset('storage/' . $mealDays[$day][$mealType]->image_path) }}" 
                                                            alt="{{ $mealDays[$day][$mealType]->title }}" 
                                                            class="rounded" width="40" height="40" style="object-fit: cover;">
                                                    @else
                                                        <div class="rounded bg-primary-light d-flex align-items-center justify-content-center" 
                                                            style="width: 40px; height: 40px;">
                                                            <i class="bi bi-cup-hot text-primary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ms-2">
                                                    <a href="{{ route('recipes.show', $mealDays[$day][$mealType]) }}" class="text-decoration-none fw-medium">
                                                        {{ $mealDays[$day][$mealType]->title }}
                                                    </a>
                                                    <div class="d-flex mt-1">
                                                        <a href="{{ route('mealplanner.edit', ['id' => $mealPlan->id, 'day' => $day, 'meal_type' => $mealType]) }}" 
                                                        class="btn btn-sm btn-outline-primary me-1" title="{{ __('Edit') }}">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <span class="text-muted"><i class="bi bi-dash-circle me-1"></i>{{ __('No recipe') }}</span>
                                                <a href="{{ route('mealplanner.edit', ['id' => $mealPlan->id, 'day' => $day, 'meal_type' => $mealType]) }}" 
                                                class="btn btn-sm btn-outline-primary ms-2" title="{{ __('Add Recipe') }}">
                                                    <i class="bi bi-plus-circle"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
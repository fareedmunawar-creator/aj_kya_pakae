@extends('layouts.app')

@section('title', __('messages.meal_planner'))

@section('content')
<div class="container py-4">
    <!-- Page Header with Breadcrumb -->
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.meal_planner') }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold">{{ __('messages.weekly_meal_planner') }}</h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createMealPlanModal">
                    <i class="bi bi-plus-lg me-1"></i> {{ __('Create Meal Plan') }}
                </button>
            </div>
        </div>
    </div>
    
    <!-- Create Meal Plan Modal -->
    <div class="modal fade" id="createMealPlanModal" tabindex="-1" aria-labelledby="createMealPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMealPlanModalLabel">{{ __('Create Meal Plan') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('mealplanner.store') }}" id="createMealPlanForm">
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
                                    <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">{{ __('End Date') }}</label>
                                    <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
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
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('createMealPlanForm').submit();">{{ __('Create Meal Plan') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Calendar View -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-calendar-week me-2"></i>{{ __('Weekly Schedule') }}
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            @foreach($days as $dayKey => $dayName)
                                <th class="text-center py-3">{{ $dayName }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Breakfast Row -->
                        <tr>
                            @foreach($days as $dayKey => $dayName)
                                <td class="p-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-primary me-2">{{ __('Breakfast') }}</span>
                                    </div>
                                    @if(isset($weeklyMealPlans) && isset($weeklyMealPlans[$dayKey]) && count($weeklyMealPlans[$dayKey]) > 0)
                                        @foreach($weeklyMealPlans[$dayKey] as $meal)
                                            @if($meal->recipes && count($meal->recipes) > 0)
                                                @foreach($meal->recipes as $recipe)
                                                    @if($recipe->pivot->meal_type === 'breakfast')
                                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-1">
                                                            <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none text-truncate me-2">{{ $recipe->title }}</a>
                                                            <form action="{{ route('mealplanner.remove', $meal->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-1" data-bs-toggle="modal" data-bs-target="#createMealPlanModal">
                                        <i class="bi bi-plus-circle me-1"></i> {{ __('Add') }}
                                    </button>
                                </td>
                            @endforeach
                        </tr>
                        
                        <!-- Lunch Row -->
                        <tr>
                            @foreach($days as $dayKey => $dayName)
                                <td class="p-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-success me-2">{{ __('Lunch') }}</span>
                                    </div>
                                    @if(isset($weeklyMealPlans) && isset($weeklyMealPlans[$dayKey]) && count($weeklyMealPlans[$dayKey]) > 0)
                                        @foreach($weeklyMealPlans[$dayKey] as $meal)
                                            @if($meal->recipes && count($meal->recipes) > 0)
                                                @foreach($meal->recipes as $recipe)
                                                    @if($recipe->pivot->meal_type === 'lunch')
                                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-1">
                                                            <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none text-truncate me-2">{{ $recipe->title }}</a>
                                                            <form action="{{ route('mealplanner.remove', $meal->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-1" data-bs-toggle="modal" data-bs-target="#createMealPlanModal">
                                        <i class="bi bi-plus-circle me-1"></i> {{ __('Add') }}
                                    </button>
                                </td>
                            @endforeach
                        </tr>
                        
                        <!-- Dinner Row -->
                        <tr>
                            @foreach($days as $dayKey => $dayName)
                                <td class="p-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-info me-2">{{ __('Dinner') }}</span>
                                    </div>
                                    @if(isset($weeklyMealPlans) && isset($weeklyMealPlans[$dayKey]) && count($weeklyMealPlans[$dayKey]) > 0)
                                        @foreach($weeklyMealPlans[$dayKey] as $meal)
                                            @if($meal->recipes && count($meal->recipes) > 0)
                                                @foreach($meal->recipes as $recipe)
                                                    @if($recipe->pivot->meal_type === 'dinner')
                                                        <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-1">
                                                            <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none text-truncate me-2">{{ $recipe->title }}</a>
                                                            <form action="{{ route('mealplanner.remove', $meal->id) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                                    <i class="bi bi-x-circle"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                    <button type="button" class="btn btn-sm btn-outline-secondary w-100 mt-1" data-bs-toggle="modal" data-bs-target="#createMealPlanModal">
                                        <i class="bi bi-plus-circle me-1"></i> {{ __('Add') }}
                                    </button>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Shopping List Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="bi bi-cart me-2"></i>{{ __('Shopping List') }}
            </h5>
        </div>
        <div class="card-body">
            <p class="text-muted">{{ __('Generate a shopping list based on your meal plan for the week.') }}</p>
            <a href="{{ route('mealplanner.shopping-list') }}" class="btn btn-success">
                <i class="bi bi-list-check me-1"></i> {{ __('Generate Shopping List') }}
            </a>
        </div>
    </div>
</div>

<script>
    // Add hover effect to meal plan items
    document.addEventListener('DOMContentLoaded', function() {
        const mealItems = document.querySelectorAll('.bg-light.rounded');
        mealItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.classList.add('shadow-sm');
            });
            item.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-sm');
            });
        });
    });
</script>
@endsection

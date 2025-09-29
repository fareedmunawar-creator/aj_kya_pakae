@extends('layouts.app')

@section('title', __('messages.meal_planner'))

@section('content')
<div class="container py-4">
    <!-- Page Header with Breadcrumb -->
    <div class="row mb-4 fade-in">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="nav-link-fancy">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.meal_planner') }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold gradient-text slide-in-left">{{ __('messages.weekly_meal_planner') }}</h1>
                @if(!isset($activeMealPlan))
                <a href="{{ route('mealplanner.create') }}" class="btn btn-gold hover-lift slide-in-right">
                    <i class="bi bi-plus-lg me-1 rotate-icon"></i> {{ __('Create Meal Plan') }}
                </a>
                @endif
            </div>
        </div>
    </div>
    
    @if(isset($activeMealPlan))
    <div class="alert alert-info mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-1">{{ $activeMealPlan->name }}</h5>
                <p class="mb-0">{{ __('Active from') }} {{ \Carbon\Carbon::parse($activeMealPlan->start_date)->format('M d, Y') }} {{ __('to') }} {{ \Carbon\Carbon::parse($activeMealPlan->end_date)->format('M d, Y') }}</p>
            </div>
            <div>
                <a href="{{ route('mealplanner.edit', $activeMealPlan->id) }}" class="btn btn-sm btn-outline-primary me-2">
                    <i class="bi bi-pencil"></i> {{ __('Edit') }}
                </a>
                <form action="{{ route('mealplanner.destroy', $activeMealPlan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this meal plan?') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash"></i> {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Weekly Calendar View -->
    <div class="card border-0 shadow-lg rounded-4 mb-4 slide-in-up">
        <div class="card-header bg-gradient-light py-3 rounded-top-4">
            <h5 class="mb-0 gradient-text">
                <i class="bi bi-calendar-week me-2 pulse"></i>{{ __('Weekly Schedule') }}
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
                                    @if(isset($selectedRecipes) && isset($selectedRecipes[$dayKey]['breakfast']) && count($selectedRecipes[$dayKey]['breakfast']) > 0)
                                        @foreach($selectedRecipes[$dayKey]['breakfast'] as $recipe)
                                            <div class="d-flex justify-content-between align-items-center p-2 bg-gradient-light rounded-3 shadow-sm mb-2 hover-lift fade-in">
                                                <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none text-truncate me-2 nav-link-fancy">{{ $recipe->title }}</a>
                                            </div>
                                        @endforeach
                                    @endif
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

                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Shopping List Card -->
    <div class="card border-0 shadow-lg rounded-4 slide-in-up" style="animation-delay: 0.3s;">
        <div class="card-header bg-gradient-light py-3 rounded-top-4">
            <h5 class="mb-0 gradient-text">
                <i class="bi bi-cart me-2 pulse"></i>{{ __('Shopping List') }}
            </h5>
        </div>
        <div class="card-body">
            <p class="text-muted fade-in" style="animation-delay: 0.5s;">{{ __('Generate a shopping list based on your meal plan for the week.') }}</p>
            <a href="{{ route('mealplanner.shopping-list') }}" class="btn btn-gold hover-lift slide-in-right" style="animation-delay: 0.7s;">
                <i class="bi bi-list-check me-1 rotate-icon"></i> {{ __('Generate Shopping List') }}
            </a>
        </div>
    </div>
</div>

<script>
    // Enhanced animations for meal plan items
    document.addEventListener('DOMContentLoaded', function() {
        // Apply animations to meal items
        const mealItems = document.querySelectorAll('.hover-lift');
        mealItems.forEach((item, index) => {
            // Add staggered animation delay
            if (!item.style.animationDelay) {
                item.style.animationDelay = (0.1 * index) + 's';
            }
            
            // Add hover effects
            item.addEventListener('mouseenter', function() {
                this.classList.add('shadow');
                this.querySelector('i')?.classList.add('bounce');
            });
            
            item.addEventListener('mouseleave', function() {
                this.classList.remove('shadow');
                this.querySelector('i')?.classList.remove('bounce');
            });
        });
        
        // Add floating animation to icons
        const icons = document.querySelectorAll('.bi');
        icons.forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.classList.add('float');
            });
            
            icon.addEventListener('mouseleave', function() {
                this.classList.remove('float');
            });
        });
    });
</script>
@endsection

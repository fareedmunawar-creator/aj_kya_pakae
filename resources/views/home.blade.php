@extends('layouts.app')

@section('title', __('messages.home'))

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold mb-3">{{ __('messages.welcome') }}</h1>
            <p class="lead mb-4">{{ __('Discover delicious recipes and plan your meals with ease') }}</p>
            
            <form action="{{ route('recipes.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-lg" 
                           placeholder="{{ __('messages.search_recipes') }}" aria-label="{{ __('messages.search_recipes') }}">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search me-2"></i>{{ __('messages.search') }}
                    </button>
                </div>
            </form>
            
            <div class="d-flex gap-3">
                <a href="{{ route('recipes.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-book me-2"></i>{{ __('Browse Recipes') }}
                </a>
                <a href="{{ route('quick.cook') }}" class="btn btn-success">
                    <i class="bi bi-lightning-charge me-2"></i>{{ __('messages.quick_cook') }}
                </a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <img src="{{ asset('images/hero-image.svg') }}" alt="Cooking Illustration" class="img-fluid rounded shadow-lg" 
                 style="max-height: 400px;" onerror="this.src='https://placehold.co/600x400?text=Aj+Kya+Pakae'">
        </div>
    </div>
    
    <!-- Popular Recipes Section -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-star-fill text-warning me-2"></i>{{ __('messages.popular_recipes') }}
            </h2>
            <a href="{{ route('recipes.index') }}" class="btn btn-sm btn-outline-primary">
                {{ __('View All') }} <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        
        <div class="row g-4">
            @foreach($recipes as $recipe)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                        @if($recipe->image)
                            <img src="{{ $recipe->image }}" class="card-img-top" alt="{{ $recipe->title }}" 
                                 style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $recipe->title }}</h5>
                            <p class="card-text text-muted small mb-3">
                                <i class="bi bi-clock me-1"></i>{{ $recipe->cooking_time ?? '30' }} min
                                <span class="mx-2">•</span>
                                <i class="bi bi-bar-chart me-1"></i>{{ $recipe->difficulty ?? 'Medium' }}
                            </p>
                            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye me-1"></i>{{ __('messages.view') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Features Section -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-basket text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold">{{ __('Pantry Management') }}</h4>
                <p class="text-muted">{{ __('Keep track of your ingredients and get notified when they expire') }}</p>
                <div class="mt-auto">
                    <a href="{{ route('pantry.index') }}" class="btn btn-outline-primary btn-sm">
                        {{ __('Manage Pantry') }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-calendar-check text-success" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold">{{ __('Meal Planning') }}</h4>
                <p class="text-muted">{{ __('Plan your meals for the week and generate shopping lists automatically') }}</p>
                <div class="mt-auto">
                    <a href="{{ route('mealplanner.index') }}" class="btn btn-outline-success btn-sm">
                        {{ __('Plan Meals') }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-heart text-danger" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold">{{ __('Save Favorites') }}</h4>
                <p class="text-muted">{{ __('Save your favorite recipes for quick access anytime') }}</p>
                <div class="mt-auto">
                    <a href="{{ route('favorites.index') }}" class="btn btn-outline-danger btn-sm">
                        {{ __('View Favorites') }} <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Cook CTA -->
    <div class="card bg-primary text-white border-0 shadow">
        <div class="card-body p-5 text-center">
            <h3 class="fw-bold mb-3">{{ __('Not sure what to cook?') }}</h3>
            <p class="lead mb-4">{{ __('Let us suggest recipes based on what you have in your pantry') }}</p>
            <a href="{{ route('quick.cook') }}" class="btn btn-lg btn-light">
                <i class="bi bi-lightning-charge me-2"></i>{{ __('messages.quick_cook') }}
            </a>
        </div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>
@endsection

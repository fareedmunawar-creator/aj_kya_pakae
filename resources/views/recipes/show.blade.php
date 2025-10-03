@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="row mb-4 fade-in">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('recipes.index') }}">{{ __('messages.recipes') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $recipe->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6 mb-4 slide-in-up">
            <div class="card recipe-detail-card h-100">
                <div class="card-body p-0">
                    <div class="recipe-image-container">
                        <img src="{{ asset('storage/' . $recipe->image_path) }}" 
                             class="img-fluid w-100 rounded" style="max-height: 400px; object-fit: cover;" 
                             alt="{{ $recipe->title }}">
                        <div class="recipe-image-overlay">
                            <span class="badge bg-gold">{{ $recipe->category->name ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 slide-in-up" style="animation-delay: 0.2s;">
            <div class="card recipe-detail-card h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h1 class="h3 mb-0 gradient-text">{{ $recipe->title }}</h1>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-secondary">{{ $recipe->description }}</p>
                        <div class="d-flex flex-wrap gap-3 mt-3">
                            <div class="badge bg-primary-light text-primary p-2 hover-lift">
                                <i class="bi bi-clock me-1"></i> {{ $recipe->cooking_time ?? '30' }} min
                            </div>
                            <div class="badge bg-secondary-light text-secondary p-2 hover-lift">
                                <i class="bi bi-people me-1"></i> {{ $recipe->servings ?? '4' }} servings
                            </div>
                            <div class="badge bg-accent-light text-accent p-2 hover-lift">
                                <i class="bi bi-tag me-1"></i> {{ $recipe->category->name ?? 'Uncategorized' }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex mt-3 mb-3">
                        <form action="{{ route('recipes.favorite', $recipe->id) }}" method="POST" class="me-2">
                            @csrf
                            @if($isFavorite)
                                @method('DELETE')
                                <button type="submit" class="btn btn-gold">
                                    <i class="bi bi-heart-fill me-1"></i> {{ __('Remove from Favorites') }}
                                </button>
                            @else
                                <button type="submit" class="btn btn-outline-gold">
                                    <i class="bi bi-heart me-1"></i> {{ __('Add to Favorites') }}
                                </button>
                            @endif
                        </form>
                    </div>
                    
                    <!-- Meal planner add form removed as requested -->
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-md-6 slide-in-up" style="animation-delay: 0.3s;">
            <div class="card recipe-detail-card h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h2 class="h5 mb-0 section-title">
                        <i class="bi bi-basket me-2 text-primary"></i>{{ __('messages.ingredients') }}
                    </h2>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush ingredient-list">
                        @if(isset($recipe->ingredients) && count($recipe->ingredients) > 0)
                            @foreach($recipe->ingredients as $ingredient)
                                <li class="list-group-item d-flex justify-content-between align-items-center hover-lift">
                                    <span>{{ $ingredient->name }}</span>
                                    <span class="badge bg-primary-light text-primary rounded-pill">{{ $ingredient->pivot->quantity }} {{ $ingredient->pivot->unit ?? '' }}</span>
                                </li>
                            @endforeach
                        @else
                            <li class="list-group-item text-center py-4">
                                <i class="bi bi-exclamation-circle text-muted me-2"></i>
                                {{ __('messages.no_ingredients') ?? 'No ingredients available' }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 slide-in-up" style="animation-delay: 0.4s;">
            <div class="card recipe-detail-card h-100">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h2 class="h5 mb-0 section-title">
                        <i class="bi bi-list-ol me-2 text-primary"></i>{{ __('messages.steps') }}
                    </h2>
                </div>
                <div class="card-body">
                    @if(isset($recipe->steps) && count($recipe->steps) > 0)
                        <ol class="list-group list-group-numbered instruction-list">
                            @foreach($recipe->steps as $step)
                                <li class="list-group-item border-0 ps-0 hover-lift">{{ $step }}</li>
                            @endforeach
                        </ol>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-exclamation-circle text-muted me-2"></i>
                            {{ __('messages.no_steps') ?? 'No steps available' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-5 slide-in-up" style="animation-delay: 0.5s;">
        <div class="col-12">
            <div class="card recipe-detail-card">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h2 class="h5 mb-0 section-title">
                        <i class="bi bi-chat-dots me-2 text-primary"></i>{{ __('messages.comments') }}
                    </h2>
                </div>
                <div class="card-body">
                    @if(isset($recipe->comments) && $recipe->comments->count() > 0)
                        <div class="mb-4">
                            @foreach($recipe->comments as $comment)
                                <div class="card mb-3 border-0 shadow-sm hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-person-circle fs-4 me-2"></i>
                                                <strong>{{ isset($comment->user) ? $comment->user->name : 'Anonymous' }}</strong>
                                            </div>
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $comment->rating)
                                                        <i class="bi bi-star-fill text-warning"></i>
                                                    @else
                                                        <i class="bi bi-star text-warning"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="mb-0">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-light text-center mb-4">
                            <i class="bi bi-chat-square text-muted me-2"></i>
                            {{ __('messages.no_comments') }}
                        </div>
                    @endif
                    
                    <div class="card shadow-sm hover-lift">
                        <div class="card-body">
                            <h5 class="mb-3 gradient-text">{{ __('messages.leave_comment') }}</h5>
                            <form action="{{ route('comments.store', $recipe) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="content" class="form-control custom-input" rows="3" placeholder="{{ __('messages.your_comment') }}" required></textarea>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">{{ __('messages.rating') }}</label>
                                        <select name="rating" class="form-select custom-select" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                            <option value="3">⭐⭐⭐ (3/5)</option>
                                            <option value="2">⭐⭐ (2/5)</option>
                                            <option value="1">⭐ (1/5)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <button type="submit" class="btn btn-primary hover-lift">
                                            <i class="bi bi-send me-1"></i> {{ __('messages.post_comment') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Nutrition Information -->
    @if(isset($recipe->nutrition) && count($recipe->nutrition) > 0)
        <div class="row mb-5 slide-in-up" style="animation-delay: 0.6s;">
            <div class="col-12">
                <div class="card recipe-detail-card">
                    <div class="card-header bg-white py-3 border-bottom-0">
                        <h2 class="h5 mb-0 section-title">
                            <i class="bi bi-pie-chart me-2 text-primary"></i>{{ __('messages.nutrition_info') }}
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @foreach($recipe->nutrition as $key => $value)
                                <div class="col-6 col-md-3">
                                    <div class="nutrition-card text-center p-3 rounded hover-lift">
                                        <h6 class="text-uppercase text-accent small mb-2">{{ $key }}</h6>
                                        <p class="h4 mb-0 gradient-text">{{ $value }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Related Recipes -->
    @if(isset($relatedRecipes) && count($relatedRecipes) > 0)
        <div class="row mb-5 slide-in-up" style="animation-delay: 0.7s;">
            <div class="col-12 mb-4">
                <h2 class="h4 mb-0 section-title">{{ __('messages.you_might_also_like') }}</h2>
            </div>
            
            @foreach($relatedRecipes as $relatedRecipe)
                <div class="col-md-6 col-lg-3 mb-4" style="animation-delay: {{ $loop->index * 0.1 + 0.8 }}s;">
                    <div class="card recipe-card hover-lift h-100">
                        <div class="card-img-container">
                            @if($relatedRecipe->image_path)
                                <img src="{{ asset($relatedRecipe->image_path) }}" 
                                    class="card-img-top" alt="{{ $relatedRecipe->title }}" 
                                    style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-primary-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="bi bi-image text-primary" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            <div class="card-img-overlay d-flex align-items-end">
                                <span class="badge bg-primary-light text-primary mb-2">
                                    <i class="bi bi-clock me-1"></i>{{ $relatedRecipe->cooking_time ?? '30' }} min
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $relatedRecipe->title }}</h5>
                            <p class="card-text text-muted small mb-3">
                                <span class="badge bg-secondary-light text-secondary me-2">
                                    <i class="bi bi-bar-chart me-1"></i>{{ $relatedRecipe->difficulty ?? 'Medium' }}
                                </span>
                                @if($relatedRecipe->category)
                                <span class="badge bg-accent-light text-accent">
                                    {{ $relatedRecipe->category->name ?? '' }}
                                </span>
                                @endif
                            </p>
                            <a href="{{ route('recipes.show', $relatedRecipe) }}" class="btn btn-sm btn-primary stretched-link">
                                <i class="bi bi-eye me-1"></i>{{ __('messages.view') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@extends('layouts.app')

@section('title', 'My Favorites - Aj Kya Pakae')

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-0 fw-bold">
                <i class="bi bi-heart-fill text-danger me-2"></i>My Favorites
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Favorites</li>
                </ol>
            </nav>
        </div>
    </div>

    @if($favorites->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach($favorites as $recipe)
                <div class="col">
                    <div class="card h-100 shadow-sm recipe-card border-0 position-relative">
                        <!-- Favorite Button -->
                        <form action="{{ route('favorites.toggle', $recipe->id) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger rounded-circle" title="Remove from favorites">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                        
                        <!-- Recipe Image -->
                        <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none">
                            @if($recipe->image)
                                <img src="{{ asset('storage/' . $recipe->image) }}" class="card-img-top recipe-img" alt="{{ $recipe->title }}">
                            @else
                                <div class="card-img-top recipe-img bg-light d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-secondary" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </a>
                        
                        <div class="card-body">
                            <!-- Recipe Category -->
                            <span class="badge bg-primary mb-2">{{ $recipe->category->name ?? 'Uncategorized' }}</span>
                            
                            <!-- Recipe Title -->
                            <h5 class="card-title mb-2">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="text-decoration-none text-dark">
                                    {{ $recipe->title }}
                                </a>
                            </h5>
                            
                            <!-- Recipe Info -->
                            <div class="d-flex justify-content-between align-items-center text-muted small mb-2">
                                <span><i class="bi bi-clock me-1"></i>{{ $recipe->prep_time + $recipe->cook_time }} min</span>
                                <span><i class="bi bi-bar-chart me-1"></i>{{ ucfirst($recipe->difficulty) }}</span>
                            </div>
                            
                            <!-- Recipe Description -->
                            <p class="card-text text-muted small">
                                {{ Str::limit($recipe->description, 80) }}
                            </p>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-person me-1"></i>{{ $recipe->user->name }}
                                </small>
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Recipe
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $favorites->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bi bi-heart text-danger" style="font-size: 4rem;"></i>
            </div>
            <h3>No favorites yet</h3>
            <p class="text-muted">You haven't added any recipes to your favorites.</p>
            <a href="{{ route('recipes.index') }}" class="btn btn-primary">
                <i class="bi bi-search me-1"></i>Browse Recipes
            </a>
        </div>
    @endif
</div>

<style>
    .recipe-img {
        height: 200px;
        object-fit: cover;
    }
    .recipe-card {
        transition: transform 0.2s ease-in-out;
    }
    .recipe-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
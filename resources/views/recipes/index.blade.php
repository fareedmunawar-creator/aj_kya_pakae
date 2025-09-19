@extends('layouts.app')

@section('title', __('messages.recipes'))

@section('styles')
<style>
    .recipe-card {
        transition: all 0.3s ease;
        opacity: 0;
        animation: fadeIn 0.5s ease forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .recipe-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .recipe-img {
        transition: all 0.5s ease;
        overflow: hidden;
    }
    .recipe-img img {
        transition: all 0.5s ease;
    }
    .recipe-card:hover .recipe-img img {
        transform: scale(1.1);
    }
    .search-container {
        animation: slideDown 0.5s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .search-btn {
        transition: all 0.3s ease;
    }
    .search-btn:hover {
        transform: scale(1.05);
    }
    .page-title {
        animation: fadeInLeft 0.5s ease;
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .details-btn {
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .details-btn:after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: -100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.3s ease;
    }
    .details-btn:hover:after {
        left: 100%;
    }
</style>
@endsection

@section('content')
    <h1 class="mb-4 text-center page-title">{{ __('messages.all_recipes') }}</h1>

    <div class="card shadow-sm mb-4 search-container">
        <div class="card-body">
            <form method="GET">
                <div class="row g-2">
                    <div class="col-md-9">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_recipes') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100 search-btn">
                            <i class="bi bi-search me-1"></i> {{ __('messages.search') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row g-4">
        @forelse($recipes as $index => $recipe)
            <div class="col-md-3 mb-4">
                <div class="card h-100 recipe-card" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="recipe-img">
                        <img src="{{ $recipe->image }}" class="card-img-top" alt="{{ $recipe->title }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <p class="card-text small text-muted">{{ Str::limit($recipe->description, 60) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-center">
                        @if(isset($day))
                            <a href="{{ route('recipes.show', ['recipe' => $recipe, 'day' => $day]) }}" class="btn btn-sm btn-outline-primary details-btn">
                                <i class="bi bi-eye me-1"></i> {{ __('messages.details') }}
                            </a>
                        @else
                            <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-primary details-btn">
                                <i class="bi bi-eye me-1"></i> {{ __('messages.details') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <i class="bi bi-journal-bookmark fs-1 text-muted mb-3"></i>
                    <h4>{{ __('messages.no_recipes_found') }}</h4>
                    <p class="text-muted">{{ __('messages.try_different_search') }}</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($recipes->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $recipes->links() }}
        </div>
    @endif
@endsection

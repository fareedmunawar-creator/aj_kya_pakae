@extends('layouts.app')

@section('title', __('messages.recipes'))

@section('content')
<style>
    a.btn {
    position: relative;
    z-index: 10;
}
</style>
    <div class="row mb-4 fade-in">
        <div class="col-12">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h1 class="h2 mb-3 mb-sm-0 gradient-text">
                    <i class="bi bi-journal-text me-2 text-primary"></i>{{ __('messages.all_recipes') }}
                </h1>
                <a href="{{ route('recipes.create') }}" class="btn btn-gold hover-lift">
                    <i class="bi bi-plus-circle me-1"></i> {{ __('messages.add_recipe') }}
                </a>
            </div>
            <hr>
        </div>
    </div>

    <div class="card recipe-detail-card mb-4 slide-in-up" style="animation-delay: 0.1s;">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="mb-0 section-title"><i class="bi bi-search me-2"></i>{{ __('messages.find_recipes') }}</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8 col-lg-9">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control custom-input" placeholder="{{ __('messages.search_recipes') }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <button type="submit" class="btn btn-primary hover-lift w-100">
                        <i class="bi bi-search me-1"></i> {{ __('messages.search') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($recipes as $key => $recipe)
            <div class="col slide-in-up" style="animation-delay: {{ 0.2 + ($key % 8) * 0.1 }}s;">
                <div class="card recipe-card h-100 hover-lift">
                    <div class="card-img-container">
                       <img src="{{ asset('storage/' . $recipe->image_path) }}" alt="Recipe Image" width="300">

                        <div class="card-img-overlay d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-end">
                                <span class="badge bg-primary-light text-primary">
                                    <i class="bi bi-clock me-1"></i>{{ $recipe->cooking_time ?? '30' }} min
                                </span>
                            </div>
                            <div class="mt-auto">
                                @if($recipe->difficulty)
                                <span class="badge bg-secondary-light text-secondary me-2">
                                    <i class="bi bi-bar-chart me-1"></i>{{ $recipe->difficulty }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-truncate">{{ $recipe->title }}</h5>
                        <p class="card-text small text-muted mb-2">{{ Str::limit($recipe->description, 80) }}</p>
                        <span class="badge bg-accent-light text-accent">
                            <i class="bi bi-tag me-1"></i>{{ $recipe->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-heart me-1"></i>{{ $recipe->favorites_count ?? 0 }}
                            </small>
                            <div>
                                @if(isset($day))
                                    <a href="{{ route('recipes.show', ['recipe' => $recipe, 'day' => $day]) }}" class="btn btn-sm btn-primary hover-lift">
                                        <i class="bi bi-eye me-1"></i> {{ __('messages.details') }}
                                    </a>
                                @else
                                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}" class="btn btn-sm btn-primary hover-lift">
                                        <i class="bi bi-eye me-1"></i> {{ __('messages.details') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 fade-in">
                <div class="card recipe-detail-card border-0 py-5">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark display-1 text-accent mb-3 pulse"></i>
                        <h4 class="gradient-text">{{ __('messages.no_recipes_found') }}</h4>
                        <p class="text-muted">{{ __('messages.try_different_search') }}</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $recipes->links() }}
    </div>
@endsection

@section('scripts')
<script>
    // Add Bootstrap hover shadow effect
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.hover-shadow');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.classList.add('shadow');
            });
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow');
            });
        });
    });
</script>
@endsection

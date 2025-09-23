@extends('layouts.app')

@section('title', __('messages.recipes'))

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h1 class="h2 mb-3 mb-sm-0">
                    <i class="bi bi-journal-text me-2 text-primary"></i>{{ __('messages.all_recipes') }}
                </h1>
                <a href="{{ route('recipes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> {{ __('messages.add_recipe') }}
                </a>
            </div>
            <hr>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0"><i class="bi bi-search me-2"></i>{{ __('messages.find_recipes') }}</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8 col-lg-9">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="{{ __('messages.search_recipes') }}" value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> {{ __('messages.search') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @forelse($recipes as $recipe)
            <div class="col">
                <div class="card h-100 shadow-sm hover-shadow">
                    <div class="position-relative overflow-hidden" style="height: 180px;">
                        <img src="{{ asset('storage/recipes/' . $recipe->image_path) }}" 
                             class="card-img-top h-100 w-100 object-fit-cover" 
                             alt="{{ $recipe->title }}">
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-primary rounded-pill">
                                <i class="bi bi-clock me-1"></i>{{ $recipe->cooking_time ?? '30' }} min
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $recipe->title }}</h5>
                        <p class="card-text small text-muted mb-0">{{ Str::limit($recipe->description, 80) }}</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-tag me-1"></i>{{ $recipe->category->name ?? 'Uncategorized' }}
                            </small>
                            <div>
                                @if(isset($day))
                                    <a href="{{ route('recipes.show', ['recipe' => $recipe, 'day' => $day]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> {{ __('messages.details') }}
                                    </a>
                                @else
                                    <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> {{ __('messages.details') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="card shadow-sm border-0 py-5">
                    <div class="card-body">
                        <i class="bi bi-journal-bookmark display-1 text-muted mb-3"></i>
                        <h4>{{ __('messages.no_recipes_found') }}</h4>
                        <p class="text-muted">{{ __('messages.try_different_search') }}</p>
                        <a href="{{ route('recipes.index') }}" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-arrow-left me-1"></i> {{ __('messages.back_to_all_recipes') }}
                        </a>
                    </div>
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

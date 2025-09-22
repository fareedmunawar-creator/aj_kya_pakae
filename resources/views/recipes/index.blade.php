@extends('layouts.app')

@section('title', __('messages.recipes'))

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('messages.recipes') }}</h1>
        <a href="{{ route('recipes.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> {{ __('messages.add_recipe') }}
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <i class="bi bi-search me-2"></i>{{ __('messages.search_and_filter') }}
        </div>
        <div class="card-body">
            <form action="{{ route('recipes.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="{{ __('messages.search_recipes') }}" name="search" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="category">
                            <option value="">{{ __('messages.all_categories') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="sort">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>{{ __('messages.newest') }}</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>{{ __('messages.oldest') }}</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>{{ __('messages.name_asc') }}</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>{{ __('messages.name_desc') }}</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel-fill me-1"></i>{{ __('messages.apply') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if($recipes->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>{{ __('messages.no_recipes_found') }}
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($recipes as $recipe)
                <div class="col">
                    <div class="card h-100 shadow-sm recipe-card">
                        <img src="{{ $recipe->image_path ? asset('storage/'.$recipe->image_path) : 'https://via.placeholder.com/300x200?text=No+Image' }}" class="card-img-top recipe-img" alt="{{ $recipe->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->name }}</h5>
                            <p class="card-text">{{ Str::limit($recipe->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-primary">{{ $recipe->category->name ?? 'Uncategorized' }}</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $recipe->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>{{ __('messages.view') }}
                                </a>
                                <div>
                                @auth
                                    @if(auth()->user()->id === $recipe->user_id || auth()->user()->is_admin)
                                        <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil me-1"></i>{{ __('messages.edit') }}
                                        </a>
                                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                <i class="bi bi-trash me-1"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $recipes->links() }}
        </div>
    @endif
</div>

<style>
    .recipe-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }
    .recipe-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .recipe-img {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
    }
</style>
@endsection

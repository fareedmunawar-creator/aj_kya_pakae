@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Page Header with Breadcrumb -->
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pantry.index') }}">{{ __('Pantry') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Item Details') }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="display-5 fw-bold">{{ __('Pantry Item Details') }}</h1>
                <a href="{{ route('pantry.edit', $pantryItem->id) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> {{ __('Edit Item') }}
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Item Information Card -->
        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>{{ __('Item Information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">{{ __('Ingredient') }}</h6>
                                <p class="fs-5">{{ $pantryItem->ingredient->name }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">{{ __('Quantity') }}</h6>
                                <p class="fs-5">
                                    <span class="badge bg-primary">{{ $pantryItem->quantity }} {{ $pantryItem->unit }}</span>
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">{{ __('Added On') }}</h6>
                                <p class="fs-5">{{ $pantryItem->created_at->format('M d, Y') }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">{{ __('Expiry Date') }}</h6>
                                <p class="fs-5">
                                    @if($pantryItem->expiry_date)
                                        {{ $pantryItem->expiry_date->format('M d, Y') }}
                                        @if($pantryItem->expiry_date->isPast())
                                            <span class="badge bg-danger ms-2">{{ __('Expired') }}</span>
                                        @elseif($pantryItem->expiry_date->diffInDays(now()) <= 7)
                                            <span class="badge bg-warning text-dark ms-2">{{ __('Expiring soon') }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">{{ __('Not specified') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($pantryItem->notes)
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6 class="text-muted mb-2">{{ __('Notes') }}</h6>
                            <p>{{ $pantryItem->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Recipes Using This Ingredient -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-journal-text me-2"></i>{{ __('Recipes Using This Ingredient') }}
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($recipes) > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            @foreach($recipes as $recipe)
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-img-top" style="height: 160px; overflow: hidden;">
                                            @if($recipe->image_path)
                                                <img src="{{ asset('storage/recipes/' . $recipe->image_path) }}" alt="{{ $recipe->title }}" class="img-fluid w-100 h-100 object-fit-cover">
                                            @else
                                                <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center text-secondary">
                                                    <i class="bi bi-image fs-1"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $recipe->title }}</h5>
                                            <p class="card-text text-muted">{{ Str::limit($recipe->description, 100) }}</p>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> {{ __('View Recipe') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-journal-x fs-1 text-secondary mb-3"></i>
                            <p class="text-muted">{{ __('No recipes found using this ingredient.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('pantry.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> {{ __('Back to Pantry') }}
        </a>
        
        <form method="POST" action="{{ route('pantry.destroy', $pantryItem->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to remove this item from your pantry?') }}');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash me-1"></i> {{ __('Remove from Pantry') }}
            </button>
        </form>
    </div>
</div>
@endsection
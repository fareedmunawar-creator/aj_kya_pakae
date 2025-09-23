@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <div class="row mb-4">
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
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-0">
                    <img src="{{ asset('storage/recipes/' . $recipe->image_path) }}" 
                         class="img-fluid w-100 rounded" style="max-height: 400px; object-fit: cover;" 
                         alt="{{ $recipe->title }}">
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h1 class="h3 mb-0 text-primary">{{ $recipe->title }}</h1>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="text-muted">{{ $recipe->description }}</p>
                        <div class="d-flex flex-wrap gap-3 mt-3">
                            <div class="badge bg-light text-dark p-2">
                                <i class="bi bi-clock me-1"></i> {{ $recipe->cooking_time ?? '30' }} min
                            </div>
                            <div class="badge bg-light text-dark p-2">
                                <i class="bi bi-people me-1"></i> {{ $recipe->servings ?? '4' }} servings
                            </div>
                            <div class="badge bg-light text-dark p-2">
                                <i class="bi bi-tag me-1"></i> {{ $recipe->category->name ?? 'Uncategorized' }}
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('mealplanner.add', $recipe) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="row g-2">
                            <div class="col-sm-8">
                                <select name="day" class="form-select" required>
                                    <option value="">{{ __('messages.select_day') }}</option>
                                    @if(request()->has('day'))
                                        <option value="{{ request('day') }}" selected>{{ __('messages.' . request('day')) }}</option>
                                    @else
                                        <option value="monday">{{ __('messages.monday') }}</option>
                                        <option value="tuesday">{{ __('messages.tuesday') }}</option>
                                        <option value="wednesday">{{ __('messages.wednesday') }}</option>
                                        <option value="thursday">{{ __('messages.thursday') }}</option>
                                        <option value="friday">{{ __('messages.friday') }}</option>
                                        <option value="saturday">{{ __('messages.saturday') }}</option>
                                        <option value="sunday">{{ __('messages.sunday') }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-calendar-plus me-1"></i> {{ __('messages.add') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-basket me-2 text-primary"></i>{{ __('messages.ingredients') }}
                    </h2>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @if(isset($recipe->ingredients) && count($recipe->ingredients) > 0)
                            @foreach($recipe->ingredients as $ingredient)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $ingredient->name }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $ingredient->pivot->quantity }}</span>
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
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-list-ol me-2 text-primary"></i>{{ __('messages.steps') }}
                    </h2>
                </div>
                <div class="card-body">
                    @if(isset($recipe->steps) && count($recipe->steps) > 0)
                        <ol class="list-group list-group-numbered">
                            @foreach($recipe->steps as $step)
                                <li class="list-group-item border-0 ps-0">{{ $step }}</li>
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
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-chat-dots me-2 text-primary"></i>{{ __('messages.comments') }}
                    </h2>
                </div>
                <div class="card-body">
                    @if(isset($recipe->comments) && $recipe->comments->count() > 0)
                        <div class="mb-4">
                            @foreach($recipe->comments as $comment)
                                <div class="card mb-3 border-0 shadow-sm">
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
                    
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="mb-3">{{ __('messages.leave_comment') }}</h5>
                            <form action="{{ route('comments.store', $recipe) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="content" class="form-control" rows="3" placeholder="{{ __('messages.your_comment') }}" required></textarea>
                                </div>
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-6">
                                        <label class="form-label mb-0">{{ __('messages.rating') }}</label>
                                        <select name="rating" class="form-select" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                            <option value="3">⭐⭐⭐ (3/5)</option>
                                            <option value="2">⭐⭐ (2/5)</option>
                                            <option value="1">⭐ (1/5)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <button type="submit" class="btn btn-primary">
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
@endsection

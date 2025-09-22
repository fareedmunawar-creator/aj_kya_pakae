@extends('layouts.app')

@section('title', $recipe->title)

@section('styles')
<style>
    .recipe-image {
        transition: all 0.5s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        animation: fadeInLeft 0.8s ease;
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .recipe-details {
        animation: fadeInRight 0.8s ease;
    }
    @keyframes fadeInRight {
        from { opacity: 0; transform: translateX(30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .recipe-title {
        border-bottom: 2px solid #4CAF50;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .ingredient-item, .step-item {
        opacity: 0;
        animation: fadeIn 0.5s ease forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .section-title {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        margin-top: 20px;
        margin-bottom: 15px;
        animation: slideIn 0.5s ease;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .add-to-planner-btn {
        transition: all 0.3s ease;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    .add-to-planner-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        animation: none;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="recipe-image rounded overflow-hidden">
                <img src="{{ $recipe->image }}" class="img-fluid w-100" alt="{{ $recipe->title }}">
            </div>
        </div>
        <div class="col-md-6 recipe-details">
            <h1 class="recipe-title">{{ $recipe->title }}</h1>
            
            <h4 class="section-title"><i class="bi bi-basket me-2"></i>{{ __('messages.ingredients') }}</h4>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($recipe->ingredients as $index => $ingredient)
                            <li class="list-group-item ingredient-item d-flex justify-content-between align-items-center" style="animation-delay: {{ $index * 0.1 }}s">
                                <span>{{ $ingredient->name }}</span>
                                <span class="badge bg-primary rounded-pill">{{ $ingredient->pivot->quantity }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <h4 class="section-title"><i class="bi bi-list-ol me-2"></i>{{ __('messages.steps') }}</h4>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <ol class="list-group list-group-numbered">
                        @foreach($recipe->steps as $index => $step)
                            <li class="list-group-item step-item" style="animation-delay: {{ ($index + count($recipe->ingredients)) * 0.1 }}s">{{ $step }}</li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <form action="{{ route('mealplanner.add', $recipe) }}" method="POST" class="mt-4 text-center">
                @csrf
                <div class="form-group mb-3">
                    <select name="day" class="form-select mb-3" required>
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
                <button class="btn btn-success btn-lg add-to-planner-btn">
                    <i class="bi bi-calendar-plus me-2"></i>{{ __('messages.add_to_meal_planner') }}
                </button>
            </form>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <h4 class="section-title"><i class="bi bi-chat-dots me-2"></i>{{ __('messages.comments') }}</h4>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    @if($recipe->comments->count() > 0)
                        @foreach($recipe->comments as $index => $comment)
                            <div class="border p-2 rounded mb-2 ingredient-item" style="animation-delay: {{ $index * 0.1 }}s">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <div>⭐ {{ $comment->rating }}/5</div>
                                </div>
                                <p class="mb-0 mt-1">{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">{{ __('messages.no_comments') }}</p>
                    @endif
                    
                    <form action="{{ route('comments.store', $recipe) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="form-control" rows="3" placeholder="{{ __('messages.leave_comment') }}" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.rating') }}</label>
                            <select name="rating" class="form-select" required>
                                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                                <option value="3">⭐⭐⭐ (3/5)</option>
                                <option value="2">⭐⭐ (2/5)</option>
                                <option value="1">⭐ (1/5)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> {{ __('messages.post_comment') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

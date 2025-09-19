@extends('layouts.app')

@section('title', __('messages.meal_planner'))

@section('styles')
<style>
    .meal-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .meal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .recipe-item {
        opacity: 0;
        animation: fadeIn 0.5s ease forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .day-header {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: white;
        border-radius: 5px 5px 0 0;
    }
    .add-recipe-btn {
        transition: all 0.3s ease;
    }
    .add-recipe-btn:hover {
        background-color: #4CAF50;
        color: white;
        transform: scale(1.05);
    }
</style>
@endsection

@section('content')
    <h1 class="mb-4 text-center animate__animated animate__fadeInDown">{{ __('messages.weekly_meal_planner') }}</h1>

    <div class="row">
        @php
            $days = [
                'monday' => __('messages.monday'),
                'tuesday' => __('messages.tuesday'),
                'wednesday' => __('messages.wednesday'),
                'thursday' => __('messages.thursday'),
                'friday' => __('messages.friday'),
                'saturday' => __('messages.saturday'),
                'sunday' => __('messages.sunday')
            ];
        @endphp
        
        @foreach($days as $dayKey => $dayName)
            <div class="col-md-3 mb-4">
                <div class="card h-100 meal-card">
                    <div class="card-header fw-bold day-header">{{ $dayName }}</div>
                    <div class="card-body">
                        @if(isset($mealPlans[$dayKey]) && count($mealPlans[$dayKey]) > 0)
                            @foreach($mealPlans[$dayKey] as $index => $meal)
                                @foreach($meal->recipes as $recipe)
                                    <div class="recipe-item mb-2 p-2 border-bottom" style="animation-delay: {{ $index * 0.1 }}s">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>{{ $recipe->title }}</span>
                                            <form action="{{ route('mealplanner.remove', $meal->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @else
                            <p class="text-muted text-center">{{ __('messages.no_meals_planned') }}</p>
                        @endif
                        <div class="text-center mt-3">
                            <a href="{{ route('recipes.index', ['day' => $dayKey]) }}" class="btn btn-sm btn-outline-primary add-recipe-btn">
                                <i class="bi bi-plus-circle me-1"></i> {{ __('messages.add_recipe') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

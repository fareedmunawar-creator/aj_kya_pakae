@extends('layouts.app')

@section('title', __('messages.home'))

@section('content')
    <div class="text-center mb-4">
        <h1 class="fw-bold">{{ __('messages.welcome') }}</h1>
        <form action="{{ route('recipes.index') }}" method="GET" class="d-flex justify-content-center mt-3">
            <input type="text" name="search" class="form-control w-50" placeholder="{{ __('messages.search_recipes') }}">
            <button class="btn btn-primary ms-2">{{ __('messages.search') }}</button>
        </form>
    </div>

    <h3 class="mt-5">{{ __('messages.popular_recipes') }}</h3>
    <div class="row g-4 mt-2">
        @foreach($recipes as $recipe)
            <div class="col-md-3">
                <div class="card h-100">
                    <img src="{{ $recipe->image }}" class="card-img-top" alt="{{ $recipe->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $recipe->title }}</h5>
                        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-sm btn-primary">{{ __('messages.view') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('quick.cook') }}" class="btn btn-lg btn-success">{{ __('messages.quick_cook') }} 🍳</a>
    </div>
@endsection

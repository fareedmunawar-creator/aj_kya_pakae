@extends('layouts.app')

@section('title', __('Edit Ingredient'))

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Edit Ingredient') }}</h1>
        <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> {{ __('Back to Ingredients') }}
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-pencil-square me-2"></i>{{ __('Edit Ingredient Details') }}
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.ingredients.update', $ingredient->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $ingredient->name) }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="unit" class="form-label">{{ __('Unit') }}</label>
                            <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit', $ingredient->unit) }}" required>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary me-md-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>{{ __('Update Ingredient') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
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
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Item') }}</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold mb-3">{{ __('Edit Pantry Item') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-pencil-square me-2"></i>{{ __('Item Information') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pantry.update', $pantryItem->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="ingredient_id" class="form-label">{{ __('Ingredient') }} <span class="text-danger">*</span></label>
                            <select id="ingredient_id" name="ingredient_id" class="form-select @error('ingredient_id') is-invalid @enderror" required>
                                <option value="">{{ __('Select Ingredient') }}</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" {{ old('ingredient_id', $pantryItem->ingredient_id) == $ingredient->id ? 'selected' : '' }}>{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                            @error('ingredient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="quantity" class="form-label">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                                <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{ old('quantity', $pantryItem->quantity) }}" step="0.01" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="unit" class="form-label">{{ __('Unit') }} <span class="text-danger">*</span></label>
                                <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror" name="unit" value="{{ old('unit', $pantryItem->unit) }}" required>
                                @error('unit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">{{ __('Expiry Date (Optional)') }}</label>
                            <input id="expiry_date" type="date" class="form-control @error('expiry_date') is-invalid @enderror" name="expiry_date" value="{{ old('expiry_date', $pantryItem->expiry_date ? $pantryItem->expiry_date->format('Y-m-d') : null) }}">
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">{{ __('Notes (Optional)') }}</label>
                            <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $pantryItem->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('pantry.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="bi bi-x-circle me-1"></i> {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i> {{ __('Update Pantry Item') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>{{ __('Tips') }}
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0 ps-0">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            {{ __('Keep track of expiry dates to reduce food waste') }}
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            {{ __('Use consistent units for easier recipe matching') }}
                        </li>
                        <li class="list-group-item border-0 ps-0">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            {{ __('Add notes for special storage instructions') }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
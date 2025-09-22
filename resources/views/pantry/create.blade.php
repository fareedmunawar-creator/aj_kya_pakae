@extends('layouts.app')

@section('title', __('Add to Pantry'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-basket me-2"></i>{{ __('Add to Pantry') }}
                    </h5>
                </div>
                <div class="card-body">

                    <form method="POST" action="{{ route('pantry.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="ingredient_id" class="form-label">{{ __('Ingredient') }}</label>
                            <select id="ingredient_id" name="ingredient_id" class="form-select @error('ingredient_id') is-invalid @enderror" required>
                                <option value="">{{ __('Select Ingredient') }}</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id }}" {{ old('ingredient_id') == $ingredient->id ? 'selected' : '' }}>{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                            @error('ingredient_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('Quantity') }}</label>
                            <input id="quantity" class="form-control @error('quantity') is-invalid @enderror" type="number" name="quantity" value="{{ old('quantity') }}" step="0.01" required />
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="unit" class="form-label">{{ __('Unit') }}</label>
                            <select id="unit" name="unit" class="form-select @error('unit') is-invalid @enderror" required>
                                <option value="">{{ __('Select Unit') }}</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">{{ __('Expiry Date (Optional)') }}</label>
                            <input id="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" type="date" name="expiry_date" value="{{ old('expiry_date') }}" />
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">{{ __('Notes (Optional)') }}</label>
                            <textarea id="notes" name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('pantry.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle me-1"></i>{{ __('Add to Pantry') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
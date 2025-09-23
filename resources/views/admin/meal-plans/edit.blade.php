@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.meal-plans.index') }}">Meal Plans</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{ $mealPlan->name }}</li>
                </ol>
            </nav>
            <h1 class="h2 mb-0">Edit Meal Plan</h1>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.meal-plans.update', $mealPlan) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Meal Plan Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name', $mealPlan->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $mealPlan->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                id="start_date" name="start_date" value="{{ old('start_date', $mealPlan->start_date) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                id="end_date" name="end_date" value="{{ old('end_date', $mealPlan->end_date) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <h4 class="mb-3">Meal Assignments</h4>
                
                @php
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    $mealTypes = ['breakfast', 'lunch', 'dinner'];
                @endphp
                
                <div class="accordion mb-4" id="mealPlanAccordion">
                    @foreach($days as $index => $day)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $day }}">
                                <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $day }}" 
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $day }}">
                                    {{ $day }}
                                </button>
                            </h2>
                            <div id="collapse{{ $day }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                aria-labelledby="heading{{ $day }}" data-bs-parent="#mealPlanAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach($mealTypes as $mealType)
                                            <div class="col-md-4 mb-3">
                                                <label for="{{ strtolower($day) }}_{{ $mealType }}" class="form-label">
                                                    {{ ucfirst($mealType) }}
                                                </label>
                                                <select class="form-select" 
                                                    id="{{ strtolower($day) }}_{{ $mealType }}" 
                                                    name="recipes[{{ strtolower($day) }}][{{ $mealType }}]">
                                                    <option value="">No Recipe Selected</option>
                                                    @foreach($recipes as $recipe)
                                                        <option value="{{ $recipe->id }}" 
                                                            {{ isset($assignedRecipes[strtolower($day)][$mealType]) && 
                                                               $assignedRecipes[strtolower($day)][$mealType] == $recipe->id ? 'selected' : '' }}>
                                                            {{ $recipe->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.meal-plans.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Update Meal Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
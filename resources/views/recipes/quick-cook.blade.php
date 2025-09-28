@extends('layouts.app')

@section('title', __('Quick Cook - Find Recipes With Your Ingredients'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">{{ __('Quick Cook') }}</h1>
                </div>
                <div class="card-body">
                    <p class="lead">{{ __('Select ingredients you have on hand and we\'ll find recipes you can make!') }}</p>
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('quick.cook') }}" method="POST" id="quickCookForm">
                        @csrf
                        
                        <div class="mb-4">
                            <h5>{{ __('Select Your Ingredients') }}</h5>
                            
                            @if(Auth::check() && count($userPantryIngredients) > 0)
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline-success btn-sm" id="selectPantryItems">
                                        <i class="bi bi-basket2"></i> {{ __('Use My Pantry Items') }}
                                    </button>
                                </div>
                            @endif
                            
                            <div class="row">
                                @foreach($ingredients->chunk(ceil($ingredients->count() / 3)) as $chunk)
                                    <div class="col-md-4">
                                        @foreach($chunk as $ingredient)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input ingredient-checkbox" type="checkbox" 
                                                    name="ingredients[]" 
                                                    value="{{ $ingredient->id }}" 
                                                    id="ingredient{{ $ingredient->id }}"
                                                    data-pantry="{{ in_array($ingredient->id, $userPantryIngredients) ? 'true' : 'false' }}">
                                                <label class="form-check-label" for="ingredient{{ $ingredient->id }}">
                                                    {{ $ingredient->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> {{ __('Find Recipes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-4" id="resultsContainer" style="display: none;">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h2 class="h4 mb-0">{{ __('Matching Recipes') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="text-center" id="loadingSpinner">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">{{ __('Loading...') }}</span>
                            </div>
                            <p>{{ __('Finding recipes...') }}</p>
                        </div>
                        
                        <div id="recipeResults"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('quickCookForm');
        const resultsContainer = document.getElementById('resultsContainer');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const recipeResults = document.getElementById('recipeResults');
        const selectPantryBtn = document.getElementById('selectPantryItems');
        
        // Use pantry items button
        if (selectPantryBtn) {
            selectPantryBtn.addEventListener('click', function() {
                // Uncheck all ingredients first
                document.querySelectorAll('.ingredient-checkbox').forEach(checkbox => {
                    checkbox.checked = false;
                });
                
                // Check only pantry items
                document.querySelectorAll('.ingredient-checkbox[data-pantry="true"]').forEach(checkbox => {
                    checkbox.checked = true;
                });
                
                // Scroll to the Find Recipes button
                document.querySelector('button[type="submit"]').scrollIntoView({behavior: 'smooth'});
            });
        }
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show results container and loading spinner
            resultsContainer.style.display = 'block';
            loadingSpinner.style.display = 'block';
            recipeResults.innerHTML = '';
            
            // Get form data
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'An error occurred');
                    });
                }
                return response.json();
            })
            .then(data => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';
                
                // Display results
                if (data.length === 0) {
                    recipeResults.innerHTML = `
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            ${"{{ __('No recipes found matching your ingredients. Try selecting different ingredients.') }}"}
                        </div>
                    `;
                    return;
                }
                
                // Create results HTML
                let resultsHTML = `
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                `;
                
                data.forEach(recipe => {
                    const matchBadgeClass = recipe.match_score >= 80 ? 'success' : 
                                          (recipe.match_score >= 50 ? 'warning' : 'danger');
                    
                    resultsHTML += `
                        <div class="col">
                            <div class="card h-100 hover-shadow">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title">${recipe.name}</h5>
                                        <span class="badge bg-${matchBadgeClass}">${recipe.match_score}% Match</span>
                                    </div>
                                    <p class="card-text">
                                        <strong>${"{{ __('You have') }}"} ${recipe.matched_count} ${"{{ __('of') }}"} ${recipe.total_required} ${"{{ __('ingredients') }}"}</strong>
                                    </p>
                                    
                                    ${recipe.missing_ingredients.length > 0 ? `
                                        <div class="mt-3">
                                            <h6>${"{{ __('Missing Ingredients:') }}"}</h6>
                                            <ul class="list-unstyled">
                                                ${recipe.missing_ingredients.map(ingredient => `
                                                    <li><i class="bi bi-dash-circle text-danger me-1"></i> ${ingredient}</li>
                                                `).join('')}
                                            </ul>
                                        </div>
                                    ` : `
                                        <div class="alert alert-success">
                                            <i class="bi bi-check-circle me-1"></i> ${"{{ __('You have all ingredients!') }}"}
                                        </div>
                                    `}
                                </div>
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('recipes.show', '') }}/${recipe.id}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> ${"{{ __('View Recipe') }}"}
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                resultsHTML += `
                    </div>
                `;
                
                recipeResults.innerHTML = resultsHTML;
            })
            .catch(error => {
                // Hide loading spinner
                loadingSpinner.style.display = 'none';
                
                // Show error message
                recipeResults.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        ${error.message || "{{ __('An error occurred while finding recipes. Please try again.') }}"}
                    </div>
                `;
            });
        });
    });
</script>
@endpush
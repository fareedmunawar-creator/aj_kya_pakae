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
                    <li class="breadcrumb-item active" aria-current="page">{{ $mealPlan->name }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0">{{ $mealPlan->name }}</h1>
                <div>
                    <a href="{{ route('admin.meal-plans.edit', $mealPlan) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-2"></i>Edit Plan
                    </a>
                    <form action="{{ route('admin.meal-plans.destroy', $mealPlan) }}" method="POST" class="d-inline ms-2" 
                          onsubmit="return confirm('Are you sure you want to delete this meal plan?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Plan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Meal Plan Details -->
    <div class="row">
        <!-- Plan Info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Plan Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-person me-2"></i>User:</span>
                            <span class="fw-bold">{{ $mealPlan->user->name ?? 'Unknown' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar-event me-2"></i>Start Date:</span>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($mealPlan->start_date)->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-calendar-check me-2"></i>End Date:</span>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($mealPlan->end_date)->format('M d, Y') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock-history me-2"></i>Created:</span>
                            <span>{{ $mealPlan->created_at->format('M d, Y H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-clock me-2"></i>Last Updated:</span>
                            <span>{{ $mealPlan->updated_at->format('M d, Y H:i') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recipe Count Summary -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Meal Summary</h5>
                </div>
                <div class="card-body">
                    @php
                        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                        $mealTypes = ['breakfast', 'lunch', 'dinner'];
                        
                        // Organize recipes by day and meal type
                        $organizedRecipes = [];
                        foreach ($mealPlan->recipes as $recipe) {
                            $pivot = $recipe->pivot;
                            $organizedRecipes[$pivot->day][$pivot->meal_type] = $recipe;
                        }
                    @endphp
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Day</th>
                                    <th>Breakfast</th>
                                    <th>Lunch</th>
                                    <th>Dinner</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($days as $day)
                                    <tr>
                                        <td class="fw-bold text-capitalize">{{ $day }}</td>
                                        @foreach($mealTypes as $mealType)
                                            <td>
                                                @if(isset($organizedRecipes[$day][$mealType]))
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img src="{{ $organizedRecipes[$day][$mealType]->image ? asset('storage/' . $organizedRecipes[$day][$mealType]->image) : asset('images/recipe-placeholder.jpg') }}" 
                                                                alt="{{ $organizedRecipes[$day][$mealType]->title }}" 
                                                                class="rounded" width="40" height="40" style="object-fit: cover;">
                                                        </div>
                                                        <div class="ms-2">
                                                            <a href="{{ route('recipes.show', $organizedRecipes[$day][$mealType]) }}" target="_blank">
                                                                {{ $organizedRecipes[$day][$mealType]->title }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-dash-circle me-1"></i>No recipe</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Shopping List Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Shopping List</h5>
                    <button class="btn btn-sm btn-success" id="generateShoppingList">
                        <i class="bi bi-cart me-2"></i>Generate Shopping List
                    </button>
                </div>
                <div class="card-body">
                    <div id="shoppingListContent" class="d-none">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    This is a combined list of all ingredients needed for the recipes in this meal plan.
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-sm" id="shoppingListTable">
                                        <thead>
                                            <tr>
                                                <th>Ingredient</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Recipes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Shopping list will be populated via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-end mt-3">
                                    <button class="btn btn-outline-primary" id="printShoppingList">
                                        <i class="bi bi-printer me-2"></i>Print Shopping List
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="shoppingListPlaceholder" class="text-center py-5">
                        <i class="bi bi-cart4 text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Shopping List Not Generated</h5>
                        <p class="text-muted">Click the "Generate Shopping List" button to create a list of ingredients needed for this meal plan.</p>
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
        const generateBtn = document.getElementById('generateShoppingList');
        const shoppingListContent = document.getElementById('shoppingListContent');
        const shoppingListPlaceholder = document.getElementById('shoppingListPlaceholder');
        const shoppingListTable = document.getElementById('shoppingListTable').querySelector('tbody');
        const printBtn = document.getElementById('printShoppingList');
        
        // Sample data - in a real app, this would come from an AJAX call to the backend
        const ingredients = [
            { name: 'Chicken Breast', quantity: '500', unit: 'g', recipes: ['Chicken Curry', 'Grilled Chicken Salad'] },
            { name: 'Rice', quantity: '300', unit: 'g', recipes: ['Chicken Curry', 'Vegetable Fried Rice'] },
            { name: 'Tomatoes', quantity: '4', unit: '', recipes: ['Pasta Sauce', 'Salad'] },
            { name: 'Olive Oil', quantity: '3', unit: 'tbsp', recipes: ['Salad Dressing', 'Pasta Sauce'] },
            { name: 'Lettuce', quantity: '1', unit: 'head', recipes: ['Salad'] },
            { name: 'Pasta', quantity: '250', unit: 'g', recipes: ['Pasta with Tomato Sauce'] }
        ];
        
        generateBtn.addEventListener('click', function() {
            // Clear previous content
            shoppingListTable.innerHTML = '';
            
            // Generate shopping list
            ingredients.forEach(ingredient => {
                const row = document.createElement('tr');
                
                const nameCell = document.createElement('td');
                nameCell.textContent = ingredient.name;
                
                const quantityCell = document.createElement('td');
                quantityCell.textContent = ingredient.quantity;
                
                const unitCell = document.createElement('td');
                unitCell.textContent = ingredient.unit;
                
                const recipesCell = document.createElement('td');
                const recipesList = document.createElement('div');
                ingredient.recipes.forEach(recipe => {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-light text-dark me-1 mb-1';
                    badge.textContent = recipe;
                    recipesList.appendChild(badge);
                });
                recipesCell.appendChild(recipesList);
                
                row.appendChild(nameCell);
                row.appendChild(quantityCell);
                row.appendChild(unitCell);
                row.appendChild(recipesCell);
                
                shoppingListTable.appendChild(row);
            });
            
            // Show content, hide placeholder
            shoppingListContent.classList.remove('d-none');
            shoppingListPlaceholder.classList.add('d-none');
        });
        
        printBtn.addEventListener('click', function() {
            window.print();
        });
    });
</script>
@endpush

@push('styles')
<style>
    @media print {
        .breadcrumb, .btn, nav, footer, .card-header {
            display: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .card-body {
            padding: 0 !important;
        }
        
        #shoppingListTable {
            width: 100% !important;
        }
    }
</style>
@endpush
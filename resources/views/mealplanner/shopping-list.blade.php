@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-cart-check me-2"></i>{{ __('Shopping List') }}
                    </h5>
                    <a href="{{ route('mealplanner.index') }}" class="btn btn-sm btn-light">
                        <i class="bi bi-arrow-left me-1"></i>{{ __('Back to Meal Planner') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(isset($groupedIngredients) && $groupedIngredients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Ingredient') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Unit') }}</th>
                                        <th class="text-center">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($groupedIngredients as $ingredient)
                                        <tr>
                                            <td>{{ $ingredient['name'] }}</td>
                                            <td>{{ $ingredient['quantity'] }}</td>
                                            <td>{{ $ingredient['unit'] }}</td>
                                            <td class="text-center">
                                                <div class="form-check d-inline-block">
                                                    <input class="form-check-input shopping-item-check" type="checkbox" value="" id="item-{{ $loop->index }}">
                                                    <label class="form-check-label" for="item-{{ $loop->index }}">
                                                        {{ __('Got it') }}
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button class="btn btn-outline-secondary" id="print-list">
                                <i class="bi bi-printer me-1"></i>{{ __('Print List') }}
                            </button>
                            <button class="btn btn-success" id="clear-checked">
                                <i class="bi bi-check-all me-1"></i>{{ __('Clear Checked Items') }}
                            </button>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>{{ __('No ingredients found in your meal plan. Add some recipes to your meal planner first.') }}
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('recipes.index') }}" class="btn btn-primary">
                                <i class="bi bi-search me-1"></i>{{ __('Browse Recipes') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle checked items (cross out text)
        const checkboxes = document.querySelectorAll('.shopping-item-check');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const row = this.closest('tr');
                if (this.checked) {
                    row.classList.add('text-decoration-line-through', 'text-muted');
                } else {
                    row.classList.remove('text-decoration-line-through', 'text-muted');
                }
            });
        });

        // Print shopping list
        document.getElementById('print-list')?.addEventListener('click', function() {
            window.print();
        });

        // Clear checked items
        document.getElementById('clear-checked')?.addEventListener('click', function() {
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    @media print {
        .card-header, .form-check, .d-flex, nav, footer {
            display: none !important;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .text-decoration-line-through {
            text-decoration: line-through;
        }
    }
</style>
@endpush
@endsection
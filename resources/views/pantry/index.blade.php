@extends('layouts.app')

@section('title', __('messages.my_pantry'))

@section('content')
<div class="container py-4">
    <!-- Page Header with Breadcrumb -->
    <div class="row mb-4">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('messages.pantry') }}</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold">{{ __('messages.pantry') }}</h1>
            <p class="text-muted">{{ __('messages.manage_your_ingredients') }}</p>
        </div>
        <div class="col-auto d-flex align-items-center">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                <i class="bi bi-plus-circle me-1"></i> {{ __('messages.add_item') }}
            </button>
        </div>
    </div>

    <!-- Pantry Items Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">
                        <i class="bi bi-basket me-2"></i>{{ __('messages.your_pantry_items') }}
                    </h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchPantry" placeholder="{{ __('messages.search_items') }}">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">{{ __('messages.item') }}</th>
                            <th>{{ __('messages.quantity') }}</th>
                            <th class="text-end pe-3">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="pantry-item">
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-light rounded-circle p-2 me-3">
                                            <i class="bi bi-egg-fried text-primary"></i>
                                        </div>
                                        <span>{{ $item->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="{{ route('pantry.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal for {{ $item->name }} -->
                            <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-pencil-square me-2 text-primary"></i>
                                                {{ __('messages.edit_item') }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('pantry.update', $item) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="name{{ $item->id }}" class="form-label">{{ __('messages.item_name') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                                        <input type="text" class="form-control" id="name{{ $item->id }}" name="name" value="{{ $item->name }}" required>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="quantity{{ $item->id }}" class="form-label">{{ __('messages.quantity') }}</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="bi bi-123"></i></span>
                                                        <input type="number" class="form-control" id="quantity{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                                <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="mb-3">
                                            <i class="bi bi-basket3 fs-1 text-secondary"></i>
                                        </div>
                                        <h5>{{ __('messages.no_items_in_pantry') }}</h5>
                                        <p class="text-muted mb-4">{{ __('messages.add_items_to_get_started') }}</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                            <i class="bi bi-plus-circle me-1"></i> {{ __('messages.add_first_item') }}
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>
                        {{ __('messages.add_new_item') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pantry.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ingredient_id" class="form-label">{{ __('messages.item_name') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <select class="form-control" id="ingredient_id" name="ingredient_id" required>
                                    <option value="">{{ __('messages.select_ingredient') }}</option>
                                    @foreach(\App\Models\Ingredient::all() as $ingredient)
                                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('messages.quantity') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-123"></i></span>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">{{ __('messages.unit') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-rulers"></i></span>
                                <select class="form-control" id="unit" name="unit" required>
                                    <option value="g">g</option>
                                    <option value="kg">kg</option>
                                    <option value="ml">ml</option>
                                    <option value="l">l</option>
                                    <option value="cup">cup</option>
                                    <option value="tbsp">tbsp</option>
                                    <option value="tsp">tsp</option>
                                    <option value="piece">piece</option>
                                    <option value="slice">slice</option>
                                    <option value="bunch">bunch</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">{{ __('messages.expiry_date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">{{ __('messages.notes') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-sticky"></i></span>
                                <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.add_item') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Search functionality for pantry items
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchPantry');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const pantryItems = document.querySelectorAll('.pantry-item');
                
                pantryItems.forEach(item => {
                    const itemName = item.querySelector('td:first-child').textContent.toLowerCase();
                    if (itemName.includes(searchTerm)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection

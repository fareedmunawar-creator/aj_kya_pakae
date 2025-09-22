@extends('layouts.app')

@section('title', __('My Pantry'))

@section('styles')
<style>
    .pantry-item {
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease forwards;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .pantry-item:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .pantry-header {
        animation: slideIn 0.5s ease;
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .add-item-btn {
        transition: all 0.3s ease;
    }
    .add-item-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .action-btn {
        transition: all 0.2s ease;
    }
    .action-btn:hover {
        transform: scale(1.1);
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center pantry-header">{{ __('My Pantry') }}</h1>

    <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-success add-item-btn" data-bs-toggle="modal" data-bs-target="#itemModal">
            <i class="bi bi-plus-circle me-1"></i> {{ __('Add Item') }}
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Item') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th class="text-center">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                <tr class="pantry-item" style="animation-delay: {{ $loop->index * 0.1 }}s">
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary action-btn me-2" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}">
                            <i class="bi bi-pencil-square"></i> {{ __('Edit') }}
                        </button>
                        <form action="{{ route('pantry.destroy', $item) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger action-btn">
                                <i class="bi bi-trash"></i> {{ __('Delete') }}
                            </button>
                        </form>
                    </td>
                </tr>
                
                <!-- Edit Modal for {{ $item->name }} -->
                <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('messages.edit_item') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pantry.update', $item) }}" method="POST">
                                @csrf @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">{{ __('messages.item_name') }}</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">{{ __('messages.quantity') }}</label>
                                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $item->quantity }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                                    <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="3" class="text-center py-4">
                        <div class="empty-state">
                            <i class="bi bi-basket3 fs-1 text-muted mb-3"></i>
                            <p>{{ __('messages.no_items_in_pantry') }}</p>
                            <button class="btn btn-sm btn-primary add-item-btn mt-2" data-bs-toggle="modal" data-bs-target="#itemModal">
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

    <!-- Add Item Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.add_new_item') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pantry.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.item_name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">{{ __('messages.quantity') }}</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('messages.add_item') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="itemModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('pantry.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('messages.pantry_item') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control mb-2" placeholder="{{ __('messages.item_name') }}" required>
                    <input type="text" name="quantity" class="form-control" placeholder="{{ __('messages.quantity') }}" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">{{ __('messages.save') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

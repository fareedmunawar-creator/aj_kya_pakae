@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Meal Plan Management</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h2 mb-0">Meal Plan Management</h1>
                <a href="{{ route('admin.meal-plans.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Create New Meal Plan
                </a>
            </div>
        </div>
    </div>

    <!-- Meal Plans Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">User</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Recipes</th>
                            <th scope="col">Created</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mealPlans as $mealPlan)
                            <tr>
                                <td>{{ $mealPlan->id }}</td>
                                <td>{{ $mealPlan->name }}</td>
                                <td>{{ $mealPlan->user->name ?? 'Unknown' }}</td>
                                <td>{{ \Carbon\Carbon::parse($mealPlan->start_date)->format('M d, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($mealPlan->end_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $mealPlan->recipes->count() }} recipes
                                    </span>
                                </td>
                                <td>{{ $mealPlan->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.meal-plans.show', $mealPlan) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.meal-plans.edit', $mealPlan) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.meal-plans.destroy', $mealPlan) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this meal plan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3">No meal plans found</h5>
                                        <p class="text-muted">Create a new meal plan to get started</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $mealPlans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table tr {
        transition: all 0.2s ease;
    }
    .table tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    /* Fix for oversized pagination buttons */
    .pagination {
        font-size: 0.9rem;
    }
    .pagination .page-link {
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush
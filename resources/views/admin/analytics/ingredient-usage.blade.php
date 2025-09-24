@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Ingredient Usage Analytics') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Ingredient Usage') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-pie me-1"></i>
            {{ __('Top 10 Most Used Ingredients') }}
        </div>
        <div class="card-body">
            <canvas id="ingredientUsageChart" width="100%" height="40"></canvas>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            {{ __('Ingredient Usage Data') }}
        </div>
        <div class="card-body">
            <table id="ingredientUsageTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Ingredient') }}</th>
                        <th>{{ __('Usage Count') }}</th>
                    </tr>
                </thead>
                <tbody id="ingredientUsageTableBody">
                    <tr>
                        <td colspan="2" class="text-center">{{ __('Loading data...') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch ingredient usage data
        fetch('/admin/analytics/ingredient-usage')
            .then(response => response.json())
            .then(data => {
                // Prepare data for chart
                const ingredients = data.map(item => item.name);
                const counts = data.map(item => item.usage_count);
                
                // Create chart
                const ctx = document.getElementById('ingredientUsageChart');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ingredients,
                        datasets: [{
                            data: counts,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(255, 206, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(199, 199, 199, 0.6)',
                                'rgba(83, 102, 255, 0.6)',
                                'rgba(40, 159, 64, 0.6)',
                                'rgba(210, 99, 132, 0.6)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(199, 199, 199, 1)',
                                'rgba(83, 102, 255, 1)',
                                'rgba(40, 159, 64, 1)',
                                'rgba(210, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            }
                        }
                    }
                });
                
                // Populate table
                const tableBody = document.getElementById('ingredientUsageTableBody');
                tableBody.innerHTML = '';
                
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.usage_count}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching ingredient usage data:', error);
                document.getElementById('ingredientUsageTableBody').innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center text-danger">{{ __('Error loading data') }}</td>
                    </tr>
                `;
            });
    });
</script>
@endsection
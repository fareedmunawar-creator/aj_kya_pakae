@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Top Recipes Analytics') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Top Recipes') }}</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    {{ __('Most Viewed Recipes') }}
                </div>
                <div class="card-body">
                    <canvas id="topRecipesChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            {{ __('Top Recipes Data') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="topRecipesTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>{{ __('Recipe Title') }}</th>
                            <th>{{ __('Views') }}</th>
                        </tr>
                    </thead>
                    <tbody id="topRecipesTableBody">
                        <tr>
                            <td colspan="2" class="text-center">{{ __('Loading data...') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch top recipes data
        fetch('/admin/analytics/top-recipes')
            .then(response => response.json())
            .then(data => {
                // Prepare data for chart
                const titles = data.map(item => item.title);
                const views = data.map(item => item.views);
                
                // Create chart
                const ctx = document.getElementById('topRecipesChart');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: titles,
                        datasets: [{
                            label: '{{ __("Views") }}',
                            data: views,
                            backgroundColor: 'rgba(0, 123, 255, 0.5)',
                            borderColor: 'rgba(0, 123, 255, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
                
                // Populate table
                const tableBody = document.getElementById('topRecipesTableBody');
                tableBody.innerHTML = '';
                
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.title}</td>
                        <td>${item.views}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching top recipes data:', error);
                document.getElementById('topRecipesTableBody').innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center text-danger">{{ __('Error loading data') }}</td>
                    </tr>
                `;
            });
    });
</script>
@endsection
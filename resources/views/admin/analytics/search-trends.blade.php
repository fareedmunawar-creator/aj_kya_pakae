@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Search Trends Analytics') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Search Trends') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-line me-1"></i>
            {{ __('Search Activity (Last 30 Days)') }}
        </div>
        <div class="card-body">
            <canvas id="searchTrendsChart" width="100%" height="40"></canvas>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            {{ __('Search Trends Data') }}
        </div>
        <div class="card-body">
            <table id="searchTrendsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Number of Searches') }}</th>
                    </tr>
                </thead>
                <tbody id="searchTrendsTableBody">
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
        // Fetch search trends data
        fetch('/admin/analytics/data/search-trends')
            .then(response => response.json())
            .then(data => {
                // Prepare data for chart
                const dates = data.map(item => item.date);
                const counts = data.map(item => item.searches);
                
                // Create chart
                const ctx = document.getElementById('searchTrendsChart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: '{{ __("Number of Searches") }}',
                            data: counts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
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
                const tableBody = document.getElementById('searchTrendsTableBody');
                tableBody.innerHTML = '';
                
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.date}</td>
                        <td>${item.searches}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching search trends data:', error);
                document.getElementById('searchTrendsTableBody').innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center text-danger">{{ __('Error loading data') }}</td>
                    </tr>
                `;
            });
    });
</script>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">{{ __('Active Users Analytics') }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item active">{{ __('Active Users') }}</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-line me-1"></i>
            {{ __('User Activity (Last 30 Days)') }}
        </div>
        <div class="card-body">
            <canvas id="activeUsersChart" width="100%" height="40"></canvas>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            {{ __('Active Users Data') }}
        </div>
        <div class="card-body">
            <table id="activeUsersTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Active Users') }}</th>
                    </tr>
                </thead>
                <tbody id="activeUsersTableBody">
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
        // Fetch active users data
        fetch('/admin/analytics/active-users')
            .then(response => response.json())
            .then(data => {
                // Prepare data for chart
                const dates = data.map(item => item.date);
                const counts = data.map(item => item.active_users);
                
                // Create chart
                const ctx = document.getElementById('activeUsersChart');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: '{{ __("Active Users") }}',
                            data: counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
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
                const tableBody = document.getElementById('activeUsersTableBody');
                tableBody.innerHTML = '';
                
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.date}</td>
                        <td>${item.active_users}</td>
                    `;
                    tableBody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Error fetching active users data:', error);
                document.getElementById('activeUsersTableBody').innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center text-danger">{{ __('Error loading data') }}</td>
                    </tr>
                `;
            });
    });
</script>
@endsection
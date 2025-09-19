@extends('layouts.app')

@section('title', __('messages.admin_dashboard'))

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('messages.admin_dashboard') }}</h1>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">{{ __('messages.top_recipes') }}</div>
                <div class="card-body">
                    <canvas id="topRecipesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">{{ __('messages.ingredient_usage') }}</div>
                <div class="card-body">
                    <canvas id="ingredientUsageChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">{{ __('messages.expiring_pantry_items') }}</div>
                <div class="card-body">
                    <canvas id="expiringPantryChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">{{ __('messages.search_trends') }}</div>
                <div class="card-body">
                    <canvas id="searchTrendsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">{{ __('messages.active_users') }}</div>
                <div class="card-body">
                    <canvas id="activeUsersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Top Recipes
    fetch('/admin/analytics/top-recipes')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('topRecipesChart'), {
                type: 'bar',
                data: {
                    labels: data.map(r => r.name),
                    datasets: [{
                        label: 'Views',
                        data: data.map(r => r.views),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)'
                    }]
                }
            });
        });

    // 2. Ingredient Usage
    fetch('/admin/analytics/ingredient-usage')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('ingredientUsageChart'), {
                type: 'pie',
                data: {
                    labels: data.map(i => i.name),
                    datasets: [{
                        label: 'Usage',
                        data: data.map(i => i.usage_count),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(153, 102, 255, 0.6)',
                        ]
                    }]
                }
            });
        });

    // 3. Expiring Pantry
    fetch('/admin/analytics/expiring-pantry')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('expiringPantryChart'), {
                type: 'bar',
                data: {
                    labels: data.map(i => i.name),
                    datasets: [{
                        label: 'Expiry in Days',
                        data: data.map(i => Math.ceil((new Date(i.expiry_date) - new Date()) / (1000*60*60*24))),
                        backgroundColor: 'rgba(255, 159, 64, 0.6)'
                    }]
                }
            });
        });

    // 4. Search Trends
    fetch('/admin/analytics/search-trends')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('searchTrendsChart'), {
                type: 'line',
                data: {
                    labels: data.map(s => s.date),
                    datasets: [{
                        label: 'Searches',
                        data: data.map(s => s.searches),
                        borderColor: 'rgba(54, 162, 235, 0.9)',
                        fill: false
                    }]
                }
            });
        });

    // 5. Active Users
    fetch('/admin/analytics/active-users')
        .then(res => res.json())
        .then(data => {
            new Chart(document.getElementById('activeUsersChart'), {
                type: 'line',
                data: {
                    labels: data.map(u => u.date),
                    datasets: [{
                        label: 'Active Users',
                        data: data.map(u => u.active_users),
                        borderColor: 'rgba(75, 192, 192, 0.9)',
                        fill: false
                    }]
                }
            });
        });
});
</script>
@endsection

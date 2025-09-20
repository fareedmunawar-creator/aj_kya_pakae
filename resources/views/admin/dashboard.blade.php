@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">{{ __('Welcome to the admin dashboard!') }}</h3>
                    
                    <!-- Admin Navigation Links -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- User Management -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-lg mb-2">{{ __('User Management') }}</h4>
                            <p class="text-gray-600 mb-4">{{ __('Manage user accounts and permissions') }}</p>
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Manage Users') }}
                            </a>
                        </div>
                        
                        <!-- Recipe Management -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-lg mb-2">{{ __('Recipe Management') }}</h4>
                            <p class="text-gray-600 mb-4">{{ __('Manage recipes and their content') }}</p>
                            <a href="{{ route('admin.recipes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Manage Recipes') }}
                            </a>
                        </div>
                        
                        <!-- Category Management -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-lg mb-2">{{ __('Category Management') }}</h4>
                            <p class="text-gray-600 mb-4">{{ __('Manage recipe categories') }}</p>
                            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Manage Categories') }}
                            </a>
                        </div>
                        
                        <!-- Ingredient Management -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-lg mb-2">{{ __('Ingredient Management') }}</h4>
                            <p class="text-gray-600 mb-4">{{ __('Manage recipe ingredients') }}</p>
                            <a href="{{ route('admin.ingredients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Manage Ingredients') }}
                            </a>
                        </div>
                        
                        <!-- Meal Plan Management -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-lg mb-2">{{ __('Meal Plan Management') }}</h4>
                            <p class="text-gray-600 mb-4">{{ __('Manage meal plans') }}</p>
                            <a href="{{ route('admin.meal-plans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                {{ __('Manage Meal Plans') }}
                            </a>
                        </div>
                        
                        <!-- Analytics -->
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h4 class="font-semibold text-lg mb-2">{{ __('Analytics') }}</h4>
                            <p class="text-gray-600 mb-4">{{ __('View site analytics and reports') }}</p>
                            <div class="space-y-2">
                                <a href="{{ route('admin.analytics.top-recipes') }}" class="block text-indigo-600 hover:text-indigo-900">{{ __('Top Recipes') }}</a>
                                <a href="{{ route('admin.analytics.ingredient-usage') }}" class="block text-indigo-600 hover:text-indigo-900">{{ __('Ingredient Usage') }}</a>
                                <a href="{{ route('admin.analytics.search-trends') }}" class="block text-indigo-600 hover:text-indigo-900">{{ __('Search Trends') }}</a>
                                <a href="{{ route('admin.analytics.active-users') }}" class="block text-indigo-600 hover:text-indigo-900">{{ __('Active Users') }}</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Analytics Charts Section -->
                    <div class="mt-10">
                        <h3 class="text-lg font-medium mb-4">{{ __('Analytics Overview') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <!-- Top Recipes Chart -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h4 class="font-semibold text-lg mb-2">{{ __('Top Recipes') }}</h4>
                                <div class="h-64">
                                    <canvas id="topRecipesChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Ingredient Usage Chart -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h4 class="font-semibold text-lg mb-2">{{ __('Ingredient Usage') }}</h4>
                                <div class="h-64">
                                    <canvas id="ingredientUsageChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Expiring Pantry Chart -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h4 class="font-semibold text-lg mb-2">{{ __('Expiring Pantry Items') }}</h4>
                                <div class="h-64">
                                    <canvas id="expiringPantryChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Search Trends Chart -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h4 class="font-semibold text-lg mb-2">{{ __('Search Trends') }}</h4>
                                <div class="h-64">
                                    <canvas id="searchTrendsChart"></canvas>
                                </div>
                            </div>
                            
                            <!-- Active Users Chart -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h4 class="font-semibold text-lg mb-2">{{ __('Active Users') }}</h4>
                                <div class="h-64">
                                    <canvas id="activeUsersChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Handle potential errors for each chart
    const createChart = (elementId, fetchUrl, chartType, dataMapper) => {
        const canvas = document.getElementById(elementId);
        if (!canvas) return;
        
        fetch(fetchUrl)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    new Chart(canvas, dataMapper(data, chartType));
                }
            })
            .catch(err => {
                console.error(`Error loading chart ${elementId}:`, err);
            });
    };
    
    // 1. Top Recipes
    createChart('topRecipesChart', '/admin/analytics/top-recipes', 'bar', (data, type) => ({
        type: type,
        data: {
            labels: data.map(r => r.name),
            datasets: [{
                label: 'Views',
                data: data.map(r => r.views),
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        }
    }));

    // 2. Ingredient Usage
    createChart('ingredientUsageChart', '/admin/analytics/ingredient-usage', 'pie', (data, type) => ({
        type: type,
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
    }));

    // 3. Expiring Pantry
    createChart('expiringPantryChart', '/admin/analytics/expiring-pantry', 'bar', (data, type) => ({
        type: type,
        data: {
            labels: data.map(i => i.name),
            datasets: [{
                label: 'Expiry in Days',
                data: data.map(i => Math.ceil((new Date(i.expiry_date) - new Date()) / (1000*60*60*24))),
                backgroundColor: 'rgba(255, 159, 64, 0.6)'
            }]
        }
    }));

    // 4. Search Trends
    createChart('searchTrendsChart', '/admin/analytics/search-trends', 'line', (data, type) => ({
        type: type,
        data: {
            labels: data.map(s => s.date),
            datasets: [{
                label: 'Searches',
                data: data.map(s => s.searches),
                borderColor: 'rgba(54, 162, 235, 0.9)',
                fill: false
            }]
        }
    }));

    // 5. Active Users
    createChart('activeUsersChart', '/admin/analytics/active-users', 'line', (data, type) => ({
        type: type,
        data: {
            labels: data.map(u => u.date),
            datasets: [{
                label: 'Active Users',
                data: data.map(u => u.active_users),
                borderColor: 'rgba(75, 192, 192, 0.9)',
                fill: false
            }]
        }
    }));
});
</script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

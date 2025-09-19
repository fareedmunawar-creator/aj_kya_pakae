<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">{{ __('Welcome to the admin dashboard!') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
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
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

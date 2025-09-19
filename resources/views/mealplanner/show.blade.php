<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $mealPlan->name }}
            </h2>
            <div>
                <a href="{{ route('mealplanner.edit', $mealPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Edit Plan') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-medium">{{ __('Plan Details') }}</h3>
                                <p class="text-sm text-gray-600">{{ __('From') }} {{ $mealPlan->start_date->format('M d, Y') }} {{ __('to') }} {{ $mealPlan->end_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <a href="{{ route('mealplanner.shopping-list', $mealPlan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                    {{ __('Generate Shopping List') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($mealDays as $day => $meals)
                            <div class="border rounded-lg overflow-hidden">
                                <div class="bg-gray-100 px-4 py-2 font-medium">
                                    {{ $dayNames[$day] }}
                                </div>
                                <div class="p-4">
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700">{{ __('Breakfast') }}</h4>
                                        @if(isset($meals['breakfast']))
                                            <div class="mt-1 flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($meals['breakfast']->image)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $meals['breakfast']->image) }}" alt="{{ $meals['breakfast']->title }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <a href="{{ route('recipes.show', $meals['breakfast']->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                        {{ $meals['breakfast']->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic mt-1">{{ __('No recipe selected') }}</p>
                                        @endif
                                    </div>

                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700">{{ __('Lunch') }}</h4>
                                        @if(isset($meals['lunch']))
                                            <div class="mt-1 flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($meals['lunch']->image)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $meals['lunch']->image) }}" alt="{{ $meals['lunch']->title }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <a href="{{ route('recipes.show', $meals['lunch']->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                        {{ $meals['lunch']->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic mt-1">{{ __('No recipe selected') }}</p>
                                        @endif
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700">{{ __('Dinner') }}</h4>
                                        @if(isset($meals['dinner']))
                                            <div class="mt-1 flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    @if($meals['dinner']->image)
                                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $meals['dinner']->image) }}" alt="{{ $meals['dinner']->title }}">
                                                    @else
                                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-3">
                                                    <a href="{{ route('recipes.show', $meals['dinner']->id) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                                                        {{ $meals['dinner']->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 italic mt-1">{{ __('No recipe selected') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pantry Item Details') }}
            </h2>
            <div>
                <a href="{{ route('pantry.edit', $pantryItem->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Edit Item') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">{{ __('Item Information') }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ __('Ingredient') }}</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pantryItem->ingredient->name }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ __('Quantity') }}</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pantryItem->quantity }} {{ $pantryItem->unit }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ __('Added On') }}</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $pantryItem->created_at->format('M d, Y') }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700">{{ __('Expiry Date') }}</h4>
                                    <p class="mt-1 text-sm text-gray-900">
                                        @if($pantryItem->expiry_date)
                                            {{ $pantryItem->expiry_date->format('M d, Y') }}
                                            @if($pantryItem->expiry_date->isPast())
                                                <span class="text-red-600 ml-2">{{ __('Expired') }}</span>
                                            @elseif($pantryItem->expiry_date->diffInDays(now()) <= 7)
                                                <span class="text-yellow-600 ml-2">{{ __('Expiring soon') }}</span>
                                            @endif
                                        @else
                                            {{ __('Not specified') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        @if($pantryItem->notes)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700">{{ __('Notes') }}</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $pantryItem->notes }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mt-8">
                        <h3 class="text-lg font-medium mb-4">{{ __('Recipes Using This Ingredient') }}</h3>
                        
                        @if(count($recipes) > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($recipes as $recipe)
                                    <div class="border rounded-lg overflow-hidden">
                                        <div class="h-40 bg-gray-200">
                                            @if($recipe->image)
                                                <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-500">
                                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h4 class="font-medium text-gray-900">{{ $recipe->title }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($recipe->description, 100) }}</p>
                                            <div class="mt-4">
                                                <a href="{{ route('recipes.show', $recipe->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                    {{ __('View Recipe') }} →
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">{{ __('No recipes found using this ingredient.') }}</p>
                        @endif
                    </div>
                    
                    <div class="mt-8 flex justify-between">
                        <a href="{{ route('pantry.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Back to Pantry') }}
                        </a>
                        
                        <form method="POST" action="{{ route('pantry.destroy', $pantryItem->id) }}" onsubmit="return confirm('{{ __('Are you sure you want to remove this item from your pantry?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Remove from Pantry') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
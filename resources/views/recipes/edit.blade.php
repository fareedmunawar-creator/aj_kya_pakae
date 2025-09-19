<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Recipe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('recipes.update', $recipe->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Recipe Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $recipe->title)" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="3">{{ old('description', $recipe->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" name="category_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $recipe->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="cooking_time" :value="__('Cooking Time (minutes)')" />
                            <x-text-input id="cooking_time" class="block mt-1 w-full" type="number" name="cooking_time" :value="old('cooking_time', $recipe->cooking_time)" required />
                            <x-input-error :messages="$errors->get('cooking_time')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="difficulty" :value="__('Difficulty')" />
                            <select id="difficulty" name="difficulty" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="easy" {{ old('difficulty', $recipe->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('difficulty', $recipe->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('difficulty', $recipe->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                            <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="image" :value="__('Recipe Image')" />
                            @if($recipe->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="h-32 w-auto object-cover rounded">
                                </div>
                            @endif
                            <input id="image" type="file" name="image" class="block mt-1 w-full" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label :value="__('Ingredients')" />
                            <div id="ingredients-container">
                                @foreach($recipe->ingredients as $index => $ingredient)
                                <div class="ingredient-row flex space-x-2 mb-2">
                                    <select name="ingredients[]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-1/2">
                                        <option value="">Select Ingredient</option>
                                        @foreach($allIngredients as $ing)
                                            <option value="{{ $ing->id }}" {{ $ingredient->id == $ing->id ? 'selected' : '' }}>{{ $ing->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-text-input name="quantities[]" placeholder="Quantity" class="w-1/4" value="{{ $ingredient->pivot->quantity }}" />
                                    <x-text-input name="units[]" placeholder="Unit" class="w-1/4" value="{{ $ingredient->pivot->unit }}" />
                                    <button type="button" class="remove-ingredient text-red-500 hover:text-red-700">×</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-ingredient" class="mt-2 px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">+ Add Ingredient</button>
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="instructions" :value="__('Cooking Instructions')" />
                            <textarea id="instructions" name="instructions" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="6">{{ old('instructions', $recipe->instructions) }}</textarea>
                            <x-input-error :messages="$errors->get('instructions')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('recipes.show', $recipe->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Recipe') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addIngredientBtn = document.getElementById('add-ingredient');
            const ingredientsContainer = document.getElementById('ingredients-container');
            
            // Add new ingredient row
            addIngredientBtn.addEventListener('click', function() {
                const ingredientRow = document.createElement('div');
                ingredientRow.className = 'ingredient-row flex space-x-2 mb-2';
                ingredientRow.innerHTML = `
                    <select name="ingredients[]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-1/2">
                        <option value="">Select Ingredient</option>
                        @foreach($allIngredients as $ing)
                            <option value="{{ $ing->id }}">{{ $ing->name }}</option>
                        @endforeach
                    </select>
                    <input name="quantities[]" placeholder="Quantity" class="w-1/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    <input name="units[]" placeholder="Unit" class="w-1/4 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                    <button type="button" class="remove-ingredient text-red-500 hover:text-red-700">×</button>
                `;
                ingredientsContainer.appendChild(ingredientRow);
                
                // Add event listener to the new remove button
                const removeBtn = ingredientRow.querySelector('.remove-ingredient');
                removeBtn.addEventListener('click', function() {
                    ingredientRow.remove();
                });
            });
            
            // Remove ingredient row
            document.querySelectorAll('.remove-ingredient').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.ingredient-row').remove();
                });
            });
        });
    </script>
</x-app-layout>
<div>
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $editing ? 'Edit Item' : 'Add Item to Package' }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $editing ? 'Update item details in this package.' : 'Add a new item to the package.' }}
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        @if(!$editing)
                        <div class="col-span-6 sm:col-span-4">
                            <label for="selectedItem" class="block text-sm font-medium text-gray-700">Item</label>
                            <select id="selectedItem" wire:model.live="selectedItem" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select an item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->items_id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedItem') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        @endif

                        <div class="col-span-6 sm:col-span-4">
                            <label for="variant_id" class="block text-sm font-medium text-gray-700">Variant</label>
                            <select id="variant_id" wire:model.live="variant_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" @if(!$selectedItem && !$editing) disabled @endif>
                                <option value="">Select a variant</option>
                                @foreach($variants as $variant)
                                    <option value="{{ $variant->variant_id }}">{{ optional($variant->item)->name }} - {{ optional($variant->color)->color_name ?? 'N/A' }}, {{ optional($variant->size)->size_label ?? 'N/A' }} ({{ $variant->barcode }})</option>
                                @endforeach
                            </select>
                            @error('variant_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="for_muslim_only" wire:model="for_muslim_only" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="for_muslim_only" class="ml-2 block text-sm text-gray-900">For Muslim students only</label>
                                </div>
                                @error('for_muslim_only') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                                <div class="flex items-center">
                                    <input type="checkbox" id="for_non_muslim_only" wire:model="for_non_muslim_only" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <label for="for_non_muslim_only" class="ml-2 block text-sm text-gray-900">For Non-Muslim students only</label>
                                </div>
                                @error('for_non_muslim_only') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" id="quantity" wire:model="quantity" min="1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price (RM)</label>
                            <input type="number" id="unit_price" wire:model="unit_price" min="0" step="0.01" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('unit_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea id="notes" wire:model="notes" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end px-4 py-3 text-right sm:px-6">
            <a href="{{ route('admin.packages.show', $package->package_id) }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                Cancel
            </a>
            <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ $editing ? 'Update' : 'Add to Package' }}
            </button>
        </div>
    </form>
</div>

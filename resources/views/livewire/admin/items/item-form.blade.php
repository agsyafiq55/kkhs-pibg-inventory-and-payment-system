<div>
    <form wire:submit="save" class="space-y-6">
        <div class="border p-6 rounded shadow-sm">
            <h2 class="text-xl font-semibold mb-6">{{ $editing ? 'Edit Item' : 'Add New Item' }}</h2>

            <!-- Basic Item Information -->
            <div class="mb-8">
                <h3 class="text-lg font-medium mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 gap-6">
                    <!-- Item Type Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Item Type</label>
                        <div class="mt-1 space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model.live="item_type" value="Book" class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <span class="ml-2">Book (Exercise Book, Textbook)</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" wire:model.live="item_type" value="School Supply" class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                <span class="ml-2">School Supply (Uniform, Sports Attire, Stationery)</span>
                            </label>
                        </div>
                        @error('item_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                        <input type="text" id="category_id" wire:model="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Book-specific fields -->
                    @if($item_type === 'Book')
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h4 class="font-medium text-gray-700 mb-3">Book Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="subject_id" class="block text-sm font-medium text-gray-700">Subject</label>
                                <select id="subject_id" wire:model="subject_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select a subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="form" class="block text-sm font-medium text-gray-700">Form</label>
                                <select id="form" wire:model="form" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select a form</option>
                                    @foreach($forms as $formOption)
                                        <option value="{{ $formOption }}">Form {{ $formOption }}</option>
                                    @endforeach
                                </select>
                                @error('form') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="stream_id" class="block text-sm font-medium text-gray-700">Stream (Optional)</label>
                                <select id="stream_id" wire:model="stream_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select a stream</option>
                                    @foreach($streams as $stream)
                                        <option value="{{ $stream->stream_id }}">{{ $stream->stream_name }}</option>
                                    @endforeach
                                </select>
                                @error('stream_id') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Only show variants checkbox for School Supply items -->
                    @if($item_type === 'School Supply')
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="has_variants" type="checkbox" wire:model.live="has_variants" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="has_variants" class="font-medium text-gray-700">This item has multiple variants</label>
                            <p class="text-gray-500">Check this box if the item comes in different colors, sizes, etc.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Stock Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium mb-4">
                    {{ ($item_type === 'School Supply' && $has_variants) ? 'Variants Information' : 'Stock Information' }}
                </h3>
                
                @if(!$has_variants || $item_type === 'Book')
                    <!-- Single Item (No Variants) -->
                    <div class="bg-gray-50 p-4 rounded mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                <input type="number" id="stock" wire:model="stock" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('stock') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" id="price" wire:model="price" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('price') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode (leave empty to auto-generate)</label>
                                <input type="text" id="barcode" wire:model="barcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('barcode') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                            
                            <div>
                                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                <select id="supplier_id" wire:model="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select a supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id') <span class="text-red-500 text-xs">{{ $message ?? 'This field is required' }}</span> @enderror
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Multiple Variants (School Supply only) -->
                    @if(!$editing)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Add variants for this item. You can define different colors, sizes, prices, and stock levels.</p>
                            <button type="button" wire:click="addVariant" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Add Another Variant
                            </button>
                        </div>
                        
                        @foreach($variants as $index => $variant)
                            <div class="bg-gray-50 p-4 rounded mb-4">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium">Variant {{ $index + 1 }}</h4>
                                    @if(count($variants) > 1)
                                        <button type="button" wire:click="removeVariant({{ $index }})" class="text-red-500 hover:text-red-700 text-sm">
                                            Remove
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="variants.{{ $index }}.color_id" class="block text-sm font-medium text-gray-700">Color (optional)</label>
                                        <select id="variants.{{ $index }}.color_id" wire:model="variants.{{ $index }}.color_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select a color</option>
                                            @foreach($colors as $color)
                                                <option value="{{ $color['color_id'] }}">{{ $color['color_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="variants.{{ $index }}.size_id" class="block text-sm font-medium text-gray-700">Size (optional)</label>
                                        <select id="variants.{{ $index }}.size_id" wire:model="variants.{{ $index }}.size_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select a size</option>
                                            @foreach($sizes as $size)
                                                <option value="{{ $size['size_id'] }}">{{ $size['size_label'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="variants.{{ $index }}.stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                        <input type="number" id="variants.{{ $index }}.stock" wire:model="variants.{{ $index }}.stock" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    
                                    <div>
                                        <label for="variants.{{ $index }}.price" class="block text-sm font-medium text-gray-700">Price</label>
                                        <input type="number" id="variants.{{ $index }}.price" wire:model="variants.{{ $index }}.price" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    
                                    <div>
                                        <label for="variants.{{ $index }}.barcode" class="block text-sm font-medium text-gray-700">Barcode (leave empty to auto-generate)</label>
                                        <input type="text" id="variants.{{ $index }}.barcode" wire:model="variants.{{ $index }}.barcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    
                                    <div>
                                        <label for="variants.{{ $index }}.supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                                        <select id="variants.{{ $index }}.supplier_id" wire:model="variants.{{ $index }}.supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select a supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        When editing an item, variants must be managed from the item detail page. Save this form first, then add or edit variants.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('admin.items.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $editing ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </form>
</div> 
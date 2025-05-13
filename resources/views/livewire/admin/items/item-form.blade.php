<div>
    <form wire:submit="save">
        <div class="relative mb-6 w-full">
            <h2 class="text-xl font-semibold mb-4">{{ $editing ? 'Edit Item' : 'Add New Item' }}</h2>
            <flux:subheading size="lg" class="mb-4">{{ __('Manage items and their information') }}</flux:subheading>
            <flux:separator variant="subtle" />
        </div>

        <!-- Basic Item Information Section -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4 text-gray-800">Basic Information</h3>
            
            <!-- Item Type Selection -->
            <div class="mb-6">
                <h4 class="text-sm font-medium text-gray-700 mb-3">Item Type <span class="text-red-500">*</span></h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <label class="border rounded-md p-4 flex items-center cursor-pointer {{ $item_type === 'Book' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300' }}">
                        <input type="radio" wire:model.live="item_type" value="Book" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 mr-3">
                        <div>
                            <span class="block font-medium">Book</span>
                            <span class="text-sm text-gray-500">Exercise Book, Textbook</span>
                        </div>
                        <div class="ml-auto">
                            @if($item_type === 'Book')
                                <div class="h-5 w-5 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            @else
                                <div class="h-5 w-5 border-2 border-gray-300 rounded-full"></div>
                            @endif
                        </div>
                    </label>
                    
                    <label class="border rounded-md p-4 flex items-center cursor-pointer {{ $item_type === 'School Supply' ? 'border-indigo-600 bg-indigo-50' : 'border-gray-300' }}">
                        <input type="radio" wire:model.live="item_type" value="School Supply" class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 mr-3">
                        <div>
                            <span class="block font-medium">School Supply</span>
                            <span class="text-sm text-gray-500">Uniform, Sports Attire, Stationery</span>
                        </div>
                        <div class="ml-auto">
                            @if($item_type === 'School Supply')
                                <div class="h-5 w-5 bg-indigo-600 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            @else
                                <div class="h-5 w-5 border-2 border-gray-300 rounded-full"></div>
                            @endif
                        </div>
                    </label>
                </div>
                @error('item_type') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
            </div>
            
            <!-- Basic Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name field: readonly for books, editable for school supplies -->
                <div class="md:col-span-2">
                    <flux:field>
                        <flux:label for="name">Name <span class="text-red-500">*</span></flux:label>
                        <flux:input 
                            id="name" 
                            wire:model="name" 
                            placeholder="Enter item name" 
                            readonly="{{ $item_type === 'Book' ? 'readonly' : false }}"
                            class="{{ $item_type === 'Book' ? 'bg-gray-100' : '' }}"
                        />
                        @if($item_type === 'Book')
                            <span class="text-sm text-gray-500">Name will be auto-generated based on subject and form</span>
                        @endif
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="md:col-span-2">
                    <flux:field>
                        <flux:label for="description">Description <span class="text-gray-500 text-sm">(Optional)</span></flux:label>
                        <flux:textarea id="description" wire:model="description" rows="3" placeholder="Enter item description" />
                        <flux:error name="description" />
                    </flux:field>
                </div>
            </div>
        </div>

        <!-- Book-specific fields -->
        @if($item_type === 'Book')
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4 text-gray-800">Book Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <flux:field>
                        <flux:label for="subject_id">Subject <span class="text-red-500">*</span></flux:label>
                        <flux:select id="subject_id" wire:model.live="subject_id">
                            <flux:select.option value="">Select a subject</flux:select.option>
                            @foreach($subjects as $subject)
                            <flux:select.option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="subject_id" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="form">Form <span class="text-red-500">*</span></flux:label>
                        <flux:select id="form" wire:model.live="form">
                            <flux:select.option value="">Select a form</flux:select.option>
                            @foreach($forms as $formOption)
                            <flux:select.option value="{{ $formOption }}">Form {{ $formOption }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="form" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="stream_id">Stream <span class="text-gray-500 text-sm">(Optional)</span></flux:label>
                        <flux:select id="stream_id" wire:model="stream_id">
                            <flux:select.option value="">Select a stream</flux:select.option>
                            @foreach($streams as $stream)
                            <flux:select.option value="{{ $stream->stream_id }}">{{ $stream->stream_name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="stream_id" />
                    </flux:field>
                </div>
            </div>
        </div>
        @endif

        <!-- School Supply Options -->
        @if($item_type === 'School Supply')
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4 text-gray-800">Product Options</h3>
            <div>
                <flux:field>
                    <flux:checkbox 
                        id="has_variants" 
                        wire:model.live="has_variants"
                        label="This item has multiple variants"
                        description="Check this box if the item comes in different colors, sizes, etc."
                    />
                </flux:field>
            </div>
        </div>
        @endif

        <!-- Stock Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-medium mb-4 text-gray-800">
                {{ ($item_type === 'School Supply' && $has_variants) ? 'Variants Information' : 'Stock Information' }}
            </h3>

            @if(!$has_variants || $item_type === 'Book')
            <!-- Single Item (No Variants) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <flux:field>
                        <flux:label for="stock">Stock <span class="text-red-500">*</span></flux:label>
                        <flux:input type="number" id="stock" wire:model="stock" min="0" placeholder="Enter available quantity" />
                        <flux:error name="stock" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="price">Price (RM) <span class="text-red-500">*</span></flux:label>
                        <flux:input type="number" id="price" wire:model="price" min="0" step="0.01" placeholder="0.00" />
                        <flux:error name="price" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="barcode">Barcode <span class="text-gray-500 text-sm">(Optional - will auto-generate if empty)</span></flux:label>
                        <flux:input id="barcode" wire:model="barcode" placeholder="Enter barcode or leave empty" />
                        <flux:error name="barcode" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="supplier_id">Supplier <span class="text-red-500">*</span></flux:label>
                        <flux:select id="supplier_id" wire:model="supplier_id">
                            <flux:select.option value="">Select a supplier</flux:select.option>
                            @foreach($suppliers as $supplier)
                            <flux:select.option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="supplier_id" />
                    </flux:field>
                </div>
            </div>
            @else
            <!-- Multiple Variants (School Supply only) -->
            @if(!$editing)
            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-4">Add variants for this item with different colors, sizes, prices, and stock levels.</p>
                <button type="button" wire:click="addVariant" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Another Variant
                </button>
            </div>

            @foreach($variants as $index => $variant)
            <div class="bg-gray-50 p-5 rounded-lg mb-5 border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-medium text-gray-800">Variant {{ $index + 1 }}</h4>
                    @if(count($variants) > 1)
                    <button type="button" wire:click="removeVariant({{ $index }})" class="inline-flex items-center text-red-500 hover:text-red-700 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-5 0h10" />
                        </svg>
                        Remove
                    </button>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <flux:field>
                            <flux:label for="variants.{{ $index }}.color_id">Color <span class="text-gray-500 text-sm">(Optional)</span></flux:label>
                            <flux:select id="variants.{{ $index }}.color_id" wire:model="variants.{{ $index }}.color_id">
                                <flux:select.option value="">Select a color</flux:select.option>
                                @foreach($colors as $color)
                                <flux:select.option value="{{ $color['color_id'] }}">{{ $color['color_name'] }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="variants.{{ $index }}.size_id">Size <span class="text-gray-500 text-sm">(Optional)</span></flux:label>
                            <flux:select id="variants.{{ $index }}.size_id" wire:model="variants.{{ $index }}.size_id">
                                <flux:select.option value="">Select a size</flux:select.option>
                                @foreach($sizes as $size)
                                <flux:select.option value="{{ $size['size_id'] }}">{{ $size['size_label'] }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="variants.{{ $index }}.stock">Stock <span class="text-red-500">*</span></flux:label>
                            <flux:input type="number" id="variants.{{ $index }}.stock" wire:model="variants.{{ $index }}.stock" min="0" placeholder="Enter quantity" />
                        </flux:field>
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="variants.{{ $index }}.price">Price (RM) <span class="text-red-500">*</span></flux:label>
                            <flux:input type="number" id="variants.{{ $index }}.price" wire:model="variants.{{ $index }}.price" min="0" step="0.01" placeholder="0.00" />
                        </flux:field>
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="variants.{{ $index }}.barcode">Barcode <span class="text-gray-500 text-sm">(Optional)</span></flux:label>
                            <flux:input id="variants.{{ $index }}.barcode" wire:model="variants.{{ $index }}.barcode" placeholder="Leave empty to auto-generate" />
                        </flux:field>
                    </div>

                    <div>
                        <flux:field>
                            <flux:label for="variants.{{ $index }}.supplier_id">Supplier <span class="text-red-500">*</span></flux:label>
                            <flux:select id="variants.{{ $index }}.supplier_id" wire:model="variants.{{ $index }}.supplier_id">
                                <flux:select.option value="">Select a supplier</flux:select.option>
                                @foreach($suppliers as $supplier)
                                <flux:select.option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
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
            <flux:button variant="filled" href="{{ route('admin.items.index') }}">
                Cancel
            </flux:button>
            <flux:button type="submit" variant="primary">
                {{ $editing ? 'Update' : 'Save' }}
            </flux:button>
        </div>
    </form>
</div>
<div>
    <form wire:submit="save" class="space-y-6">
        <div class="border p-6 rounded shadow-sm">
            <h2 class="text-xl font-semibold mb-6">{{ $editing ? 'Edit Variant' : 'Add New Variant' }} for "{{ $item->name }}"</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="color_id" class="block text-sm font-medium text-gray-700">Color (optional)</label>
                    <select id="color_id" wire:model="color_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a color</option>
                        @foreach($colors as $color)
                            <option value="{{ $color['color_id'] }}">{{ $color['color_name'] }}</option>
                        @endforeach
                    </select>
                    @error('color_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="size_id" class="block text-sm font-medium text-gray-700">Size (optional)</label>
                    <select id="size_id" wire:model="size_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a size</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size['size_id'] }}">{{ $size['size_label'] }}</option>
                        @endforeach
                    </select>
                    @error('size_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700">Supplier</label>
                    <select id="supplier_id" wire:model="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="barcode" class="block text-sm font-medium text-gray-700">Barcode (leave empty to auto-generate)</label>
                    <input type="text" id="barcode" wire:model="barcode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('barcode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" id="stock" wire:model="stock" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('stock') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="price" wire:model="price" min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('admin.items.show', $item->items_id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $editing ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </form>
</div> 
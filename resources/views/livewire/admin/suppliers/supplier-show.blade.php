<div>
    <div class="space-y-6">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="flex justify-between items-center px-4 py-5 border-b border-gray-200 sm:px-6">
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Supplier Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Supplier details and supplied items.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.suppliers.edit', $supplier->supplier_id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Edit
                    </a>
                    <a href="{{ route('admin.suppliers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Back to List
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $supplier->supplier_name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Contact Information</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-line">{{ $supplier->contact_info ?? 'N/A' }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Total Items Supplied</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $variants->total() }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="flex justify-between items-center px-4 py-5 border-b border-gray-200 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Supplied Items</h3>
                <div>
                    <input type="text" wire:model.live.debounce.300ms="search" class="px-4 py-2 rounded border" placeholder="Search items...">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barcode</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($variants as $variant)
                        <tr data-barcode="{{ $variant->barcode }}">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $variant->item->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    <span>{{ $variant->barcode }}</span>
                                    <div class="barcode-container">
                                        {!! $variant->barcode_image !!}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $variant->color->color_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $variant->size->size_label ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $variant->stock }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ number_format($variant->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.items.show', $variant->items_id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                    View
                                </a>
                                <button type="button" onclick="printBarcode('{{ $variant->barcode }}', '{{ addslashes($variant->item->name) }}')" class="text-yellow-500 hover:text-yellow-700 block mt-1">
                                    Print Barcode
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No items found for this supplier.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $variants->links() }}
            </div>
        </div>

        <iframe id="print-frame" style="display: none;"></iframe>

        <script src="{{ asset('js/barcode-printer.js') }}?v={{ time() }}"></script>

        <style>
            .barcode-container {
                display: inline-block;
            }

            .barcode-container svg {
                max-width: 150px;
                height: auto;
            }
        </style>
    </div>
</div>
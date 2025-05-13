<div>
    <div class="flex justify-between items-center mb-4">
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <div class="flex flex-wrap gap-2">
                <input type="text" wire:model.live.debounce.300ms="search" class="px-4 py-2 rounded border" placeholder="Search items...">
                
                <select wire:model.live="itemTypeFilter" class="px-4 py-2 rounded border">
                    <option value="">All Types</option>
                    <option value="Book">Books</option>
                    <option value="School Supply">School Supplies</option>
                </select>
                
                <select wire:model.live="perPage" class="px-4 py-2 rounded border">
                    <option value="10">10 per page</option>
                    <option value="25">25 per page</option>
                    <option value="50">50 per page</option>
                    <option value="100">100 per page</option>
                </select>
            </div>
        </div>
        <a href="{{ route('admin.items.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Add New Item
        </a>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item Type</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Variants</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->name }}</td>
                        <td class="px-6 py-4 border-b border-gray-200">
                            <div class="truncate max-w-xs">{{ $item->description ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->item_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $item->variants()->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            <a href="{{ route('admin.items.show', $item->items_id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                View
                            </a>
                            <a href="{{ route('admin.items.edit', $item->items_id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                                Edit
                            </a>
                            <button wire:click="deleteItem({{ $item->items_id }})" wire:confirm="Are you sure you want to delete this item and all its variants?" class="text-red-500 hover:text-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center">No items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div> 
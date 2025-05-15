<div>
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-end">
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <flux:field class="w-full sm:w-64">
                <flux:label for="search">Search</flux:label>
                <flux:input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="Search by name or description" />
            </flux:field>
        </div>
        
        <div class="flex items-end gap-4">
            <flux:field class="w-full sm:w-24">
                <flux:label for="perPage">Per Page</flux:label>
                <flux:select wire:model.live="perPage" id="perPage">
                    <flux:select.option value="10">10</flux:select.option>
                    <flux:select.option value="25">25</flux:select.option>
                    <flux:select.option value="50">50</flux:select.option>
                    <flux:select.option value="100">100</flux:select.option>
                </flux:select>
            </flux:field>
            
            <flux:button href="{{ route('admin.streams.create') }}" variant="primary">
                Add Stream
            </flux:button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('stream_id')">
                        ID
                        @if($sortField === 'stream_id')
                            @if($sortDirection === 'asc')
                                <span>↑</span>
                            @else
                                <span>↓</span>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('stream_name')">
                        Name
                        @if($sortField === 'stream_name')
                            @if($sortDirection === 'asc')
                                <span>↑</span>
                            @else
                                <span>↓</span>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Items Count
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($streams as $stream)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $stream->stream_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $stream->stream_name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                            {{ $stream->description ?? 'No description' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $stream->items->count() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <flux:button href="{{ route('admin.streams.show', $stream) }}" variant="filled" size="xs">
                                    View
                                </flux:button>
                                <flux:button href="{{ route('admin.streams.edit', $stream) }}" variant="filled" size="xs">
                                    Edit
                                </flux:button>
                                <flux:button wire:click="deleteStream({{ $stream->stream_id }})" wire:confirm="Are you sure you want to delete this stream?" variant="danger" size="xs">
                                    Delete
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No streams found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $streams->links() }}
    </div>
</div> 
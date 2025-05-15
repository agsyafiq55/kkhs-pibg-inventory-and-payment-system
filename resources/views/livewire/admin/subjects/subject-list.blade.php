<div>
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-end">
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            <flux:field class="w-full sm:w-64">
                <flux:label for="search">Search</flux:label>
                <flux:input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="Search by code or name" />
            </flux:field>
            
            <flux:field class="w-full sm:w-48">
                <flux:label for="typeFilter">Filter by Type</flux:label>
                <flux:select wire:model.live="typeFilter" id="typeFilter">
                    <flux:select.option value="">All Types</flux:select.option>
                    <flux:select.option value="core">Core</flux:select.option>
                    <flux:select.option value="elective">Elective</flux:select.option>
                </flux:select>
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
            
            <flux:button href="{{ route('admin.subjects.create') }}" variant="primary">
                Add Subject
            </flux:button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('subject_code')">
                        Code
                        @if($sortField === 'subject_code')
                            @if($sortDirection === 'asc')
                                <span>↑</span>
                            @else
                                <span>↓</span>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('subject_name')">
                        Name
                        @if($sortField === 'subject_name')
                            @if($sortDirection === 'asc')
                                <span>↑</span>
                            @else
                                <span>↓</span>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('type')">
                        Type
                        @if($sortField === 'type')
                            @if($sortDirection === 'asc')
                                <span>↑</span>
                            @else
                                <span>↓</span>
                            @endif
                        @endif
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Restrictions
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($subjects as $subject)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $subject->subject_code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $subject->subject_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <flux:badge color="{{ $subject->type === 'core' ? 'blue' : 'amber' }}">
                                {{ ucfirst($subject->type) }}
                            </flux:badge>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($subject->for_muslim_only)
                                <flux:badge color="emerald">Muslim Only</flux:badge>
                            @elseif($subject->for_non_muslim_only)
                                <flux:badge color="purple">Non-Muslim Only</flux:badge>
                            @else
                                <flux:badge color="gray">None</flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <flux:button href="{{ route('admin.subjects.show', $subject) }}" variant="filled" size="xs">
                                    View
                                </flux:button>
                                <flux:button href="{{ route('admin.subjects.edit', $subject) }}" variant="filled" size="xs">
                                    Edit
                                </flux:button>
                                <flux:button wire:click="deleteSubject({{ $subject->subject_id }})" wire:confirm="Are you sure you want to delete this subject?" variant="danger" size="xs">
                                    Delete
                                </flux:button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No subjects found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $subjects->links() }}
    </div>
</div> 
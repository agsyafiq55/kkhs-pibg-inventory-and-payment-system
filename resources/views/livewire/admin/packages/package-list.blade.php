<div>
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search packages..." class="w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="w-full md:w-1/3">
                    <select wire:model.live="class_filter" class="w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">All Classrooms</option>
                        @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->class_id }}">{{ $classroom->class_name }}</option>
                        @endforeach
                    </select>
                </div>
                <a href="{{ route('admin.packages.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded">
                    Add New Package
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Classroom</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($packages as $package)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $package->package_name }}
                            </div>
                            @if($package->description)
                            <div class="text-sm text-gray-500 truncate max-w-xs">
                                {{ $package->description }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $package->classroom->class_name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">RM {{ number_format($package->total_price, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $package->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.packages.show', $package->package_id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('admin.packages.edit', $package->package_id) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                            <button wire:click="deletePackage({{ $package->package_id }})" wire:confirm="Are you sure you want to delete this package?" class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No packages found. <a href="{{ route('admin.packages.create') }}" class="text-indigo-600 hover:underline">Create one now</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 py-3 border-t">
            {{ $packages->links() }}
        </div>
    </div>
</div>
<div>
    <div class="flex justify-between items-center mb-4">
        <div>
            <input type="text" wire:model.live.debounce.300ms="search" class="px-4 py-2 rounded border" placeholder="Search classes...">
            <select wire:model.live="perPage" class="px-4 py-2 rounded border ml-2">
                <option value="10">10 per page</option>
                <option value="25">25 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>
        </div>
        <a href="{{ route('admin.classrooms.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Add New Class
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
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Class Name</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Students Count</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($classrooms as $classroom)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $classroom->class_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $classroom->students_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                            <a href="{{ route('admin.classrooms.show', $classroom->class_id) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                View
                            </a>
                            <a href="{{ route('admin.classrooms.edit', $classroom->class_id) }}" class="text-yellow-500 hover:text-yellow-700 mr-2">
                                Edit
                            </a>
                            <button wire:click="deleteClassroom({{ $classroom->class_id }})" wire:confirm="Are you sure you want to delete this class?" class="text-red-500 hover:text-red-700">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap border-b border-gray-200 text-center">No classes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $classrooms->links() }}
    </div>
</div> 
<div>
    <form wire:submit="save" class="space-y-6">
        <div class="border p-6 rounded shadow-sm">
            <h2 class="text-xl font-semibold mb-6">{{ $editing ? 'Edit Class' : 'Add New Class' }}</h2>

            <div>
                <label for="class_name" class="block text-sm font-medium text-gray-700">Class Name</label>
                <input type="text" id="class_name" wire:model="class_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('class_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('admin.classrooms.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $editing ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </form>
</div> 
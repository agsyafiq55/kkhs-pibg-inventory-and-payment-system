<div>
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $editing ? 'Edit Package' : 'Create New Package' }}</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $editing ? 'Update the package details.' : 'Create a new package for students in a classroom.' }}
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-4">
                            <label for="package_name" class="block text-sm font-medium text-gray-700">Package Name</label>
                            <input type="text" id="package_name" wire:model="package_name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('package_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <label for="class_id" class="block text-sm font-medium text-gray-700">Classroom</label>
                            <select id="class_id" wire:model="class_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select a classroom</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->class_id }}">{{ $classroom->class_name }}</option>
                                @endforeach
                            </select>
                            @error('class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" wire:model="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                            @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" wire:model="is_active" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                            </div>
                            @error('is_active') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end px-4 py-3 text-right sm:px-6">
            <a href="{{ route('admin.packages.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                Cancel
            </a>
            <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ $editing ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</div>

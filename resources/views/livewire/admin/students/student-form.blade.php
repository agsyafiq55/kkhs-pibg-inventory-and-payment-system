<div>
    <form wire:submit="save" class="space-y-6">
        <div class="border p-6 rounded shadow-sm">
            <h2 class="text-xl font-semibold mb-6">{{ $editing ? 'Edit Student' : 'Add New Student' }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <flux:input type="text" id="name" wire:model="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </flux:input>
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="class_id" class="block text-sm font-medium text-gray-700">Class</label>
                    <flux:select id="class_id" wire:model="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <flux:select.option value="">Select a class</flux:select.option>
                        @foreach($classrooms as $classroom)
                            <flux:select.option value="{{ $classroom->class_id }}">{{ $classroom->class_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    @error('class_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="daftar_no" class="block text-sm font-medium text-gray-700">Daftar No</label>
                    <flux:input type="text" id="daftar_no" wire:model="daftar_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </flux:input>
                    @error('daftar_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="ic_no" class="block text-sm font-medium text-gray-700">IC Number</label>
                    <flux:input type="text" id="ic_no" wire:model="ic_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </flux:input>
                    @error('ic_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="form" class="block text-sm font-medium text-gray-700">Form</label>
                    <flux:input type="text" id="form" wire:model="form" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </flux:input>
                    @error('form') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="stream" class="block text-sm font-medium text-gray-700">Stream</label>
                    <flux:input type="text" id="stream" wire:model="stream" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </flux:input>
                    @error('stream') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <flux:select id="gender" wire:model="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <flux:select.option value="">Select gender</flux:select.option>
                        <flux:select.option value="Male">Male</flux:select.option>
                        <flux:select.option value="Female">Female</flux:select.option>
                    </flux:select>
                    @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="previous_school" class="block text-sm font-medium text-gray-700">Previous School</label>
                    <flux:input type="text" id="previous_school" wire:model="previous_school" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </flux:input>
                    @error('previous_school') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <div class="flex items-center">
                        <input type="checkbox" id="islam" wire:model="islam" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="islam" class="ml-2 block text-sm text-gray-700">Islam</label>
                        @error('islam') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="scholarship" wire:model="scholarship" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="scholarship" class="ml-2 block text-sm text-gray-700">Scholarship</label>
                        @error('scholarship') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('admin.students.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $editing ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </form>
</div> 
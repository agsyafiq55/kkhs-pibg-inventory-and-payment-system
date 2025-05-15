<div>
    <form wire:submit="save" class="space-y-6">
        <div class="border p-6 rounded shadow-sm">
            <flux:heading size="lg" class="mb-6">{{ $editing ? 'Edit Student' : 'Add New Student' }}</flux:heading>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <flux:field>
                        <flux:label for="name">Name</flux:label>
                        <flux:input type="text" id="name" wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="class_id">Class</flux:label>
                        <flux:select id="class_id" wire:model="class_id">
                            <flux:select.option value="">Select a class</flux:select.option>
                            @foreach($classrooms as $classroom)
                                <flux:select.option value="{{ $classroom->class_id }}">{{ $classroom->class_name }} (Form {{ $classroom->form }} {{ $classroom->stream }})</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="class_id" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="academic_year">Academic Year</flux:label>
                        <flux:input type="number" id="academic_year" wire:model="academic_year" min="2000" max="2100" />
                        <flux:error name="academic_year" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="daftar_no">Daftar No</flux:label>
                        <flux:input type="text" id="daftar_no" wire:model="daftar_no" />
                        <flux:error name="daftar_no" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="ic_no">IC Number</flux:label>
                        <flux:input type="text" id="ic_no" wire:model="ic_no" />
                        <flux:error name="ic_no" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="gender">Gender</flux:label>
                        <flux:select id="gender" wire:model="gender">
                            <flux:select.option value="">Select gender</flux:select.option>
                            <flux:select.option value="Male">Male</flux:select.option>
                            <flux:select.option value="Female">Female</flux:select.option>
                        </flux:select>
                        <flux:error name="gender" />
                    </flux:field>
                </div>

                <div>
                    <flux:field>
                        <flux:label for="previous_school">Previous School</flux:label>
                        <flux:input type="text" id="previous_school" wire:model="previous_school" />
                        <flux:error name="previous_school" />
                    </flux:field>
                </div>

                <div class="flex items-center space-x-4">
                    <flux:field variant="inline">
                        <flux:label for="islam">Islam</flux:label>
                        <flux:checkbox id="islam" wire:model="islam" />
                        <flux:error name="islam" />
                    </flux:field>

                    <flux:field variant="inline">
                        <flux:label for="scholarship">Scholarship</flux:label>
                        <flux:checkbox id="scholarship" wire:model="scholarship" />
                        <flux:error name="scholarship" />
                    </flux:field>
                </div>
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('admin.students.index') }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Cancel
                </a>
                <flux:button type="submit" variant="primary">
                    {{ $editing ? 'Update' : 'Save' }}
                </flux:button>
            </div>
        </div>
    </form>
</div> 
<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <flux:heading size="lg">Add New Student to {{ $classroom->class_name }}</flux:heading>
            <flux:text class="mt-2">Add a new student directly to this class for a specific academic year.</flux:text>
        </div>
        
        <div class="p-6">
            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label for="academic_year">Academic Year</flux:label>
                        <flux:input type="number" id="academic_year" wire:model="academic_year" min="2000" max="2100" />
                        <flux:description>The academic year this student will be assigned to this class.</flux:description>
                        <flux:error name="academic_year" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label for="name">Name</flux:label>
                        <flux:input type="text" id="name" wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label for="daftar_no">Daftar No</flux:label>
                        <flux:input type="text" id="daftar_no" wire:model="daftar_no" />
                        <flux:error name="daftar_no" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label for="ic_no">IC Number</flux:label>
                        <flux:input type="text" id="ic_no" wire:model="ic_no" />
                        <flux:error name="ic_no" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label for="gender">Gender</flux:label>
                        <flux:select id="gender" wire:model="gender">
                            <flux:select.option value="">Select gender</flux:select.option>
                            <flux:select.option value="Male">Male</flux:select.option>
                            <flux:select.option value="Female">Female</flux:select.option>
                        </flux:select>
                        <flux:error name="gender" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label for="previous_school">Previous School</flux:label>
                        <flux:input type="text" id="previous_school" wire:model="previous_school" />
                        <flux:error name="previous_school" />
                    </flux:field>
                    
                    <div class="flex items-center space-x-4 col-span-2">
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
                
                <div class="flex justify-end space-x-3">
                    <flux:button as="a" href="{{ route('admin.classrooms.show', $classroom->class_id) }}">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Add Student
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div> 
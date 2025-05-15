<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 gap-6">
            @if($isEdit)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <flux:text class="text-sm text-gray-500">Subject Code</flux:text>
                    <flux:text class="font-medium">{{ $subject->subject_code ?? '' }}</flux:text>
                    <flux:description>Subject codes cannot be changed after creation.</flux:description>
                </div>
            @endif
            
            <flux:field>
                <flux:label for="subject_name">Subject Name</flux:label>
                <flux:input wire:model="subject_name" id="subject_name" type="text" placeholder="e.g. Mathematics" />
                @if(!$isEdit)
                    <flux:description>The subject code will be auto-generated based on the subject name.</flux:description>
                @endif
                <flux:error name="subject_name" />
            </flux:field>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <flux:field>
                <flux:label for="type">Type</flux:label>
                <flux:select wire:model="type" id="type">
                    <flux:select.option value="core">Core</flux:select.option>
                    <flux:select.option value="elective">Elective</flux:select.option>
                </flux:select>
                <flux:error name="type" />
            </flux:field>

            <flux:field variant="inline" class="flex items-center">
                <flux:label for="for_muslim_only" class="mr-4">For Muslim Students Only</flux:label>
                <flux:switch wire:model="for_muslim_only" id="for_muslim_only" />
                <flux:error name="for_muslim_only" />
            </flux:field>

            <flux:field variant="inline" class="flex items-center">
                <flux:label for="for_non_muslim_only" class="mr-4">For Non-Muslim Students Only</flux:label>
                <flux:switch wire:model="for_non_muslim_only" id="for_non_muslim_only" />
                <flux:error name="for_non_muslim_only" />
            </flux:field>
        </div>

        <div class="flex justify-end space-x-3">
            <flux:button href="{{ route('admin.subjects.index') }}" variant="filled">Cancel</flux:button>
            <flux:button type="submit" variant="primary">{{ $isEdit ? 'Update Subject' : 'Create Subject' }}</flux:button>
        </div>
    </form>
</div> 
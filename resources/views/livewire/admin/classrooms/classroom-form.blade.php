<div>
    <form wire:submit="save" class="space-y-6">
        <h2 class="text-xl font-semibold mb-6">{{ $editing ? 'Edit Class' : 'Add New Class' }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <flux:field>
                    <flux:label for="form">Form</flux:label>
                    <flux:select id="form" wire:model.live="form">
                        <flux:select.option value="">Select form</flux:select.option>
                        <flux:select.option value="1">Form 1</flux:select.option>
                        <flux:select.option value="2">Form 2</flux:select.option>
                        <flux:select.option value="3">Form 3</flux:select.option>
                        <flux:select.option value="4">Form 4</flux:select.option>
                        <flux:select.option value="5">Form 5</flux:select.option>
                    </flux:select>
                    <flux:error name="form" />
                </flux:field>
            </div>

            <div>
                <flux:field>
                    <flux:label for="class_name">Class Name</flux:label>
                    <flux:select id="class_name" wire:model.live="class_name">
                        <flux:select.option value="">Select class</flux:select.option>
                        <flux:select.option value="AMANAH">AMANAH</flux:select.option>
                        <flux:select.option value="BESTARI">BESTARI</flux:select.option>
                        <flux:select.option value="CERIA">CERIA</flux:select.option>
                        <flux:select.option value="DINAMIK">DINAMIK</flux:select.option>
                        <flux:select.option value="KREATIF">KREATIF</flux:select.option>
                        <flux:select.option value="MULIA">MULIA</flux:select.option>
                        <flux:select.option value="RAJIN">RAJIN</flux:select.option>
                        <flux:select.option value="SABAR">SABAR</flux:select.option>
                        <flux:select.option value="TEKUN">TEKUN</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>

            <div>
                <flux:field>
                    <flux:label for="stream">Stream</flux:label>
                    <flux:select id="stream" wire:model="stream">
                        <flux:select.option value="">Select stream</flux:select.option>
                        <flux:select.option value="1">Science</flux:select.option>
                        <flux:select.option value="2">Business</flux:select.option>
                        <flux:select.option value="3">Arts</flux:select.option>
                        <flux:select.option value="4">Accounting</flux:select.option>
                    </flux:select>
                    <flux:error name="stream" />
                </flux:field>
            </div>

            <div>
                <flux:field>
                    <flux:label>Full Class Name Preview</flux:label>
                    <div class="p-2 bg-gray-100 border rounded">
                        <flux:text>{{ $full_class_name ?: 'Will be automatically generated' }}</flux:text>
                    </div>
                    <flux:description>This will be automatically generated from Form and Class Name</flux:description>
                </flux:field>
            </div>
        </div>

        <div class="mt-4" wire:key="full-class-name-section">
            @if(!empty($full_class_name))
            <flux:callout icon="information-circle">
                <flux:callout.heading>Full Class Name</flux:callout.heading>
                <flux:callout.text>
                    This class will be saved as: <strong>{{ $full_class_name }}</strong>
                </flux:callout.text>
            </flux:callout>
            @else
            <p class="text-sm text-gray-500">Please select both a form and class name to see the full class name.</p>
            @endif
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <flux:button href="{{ route('admin.classrooms.index') }}" variant="filled">Cancel</flux:button>
            <flux:button type="submit" variant="primary">{{ $editing ? 'Update Class' : 'Create Class' }}</flux:button>
        </div>
    </form>
</div>
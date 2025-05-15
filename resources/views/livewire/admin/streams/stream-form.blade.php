<div>
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 gap-6">
            <flux:field>
                <flux:label for="stream_name">Stream Name</flux:label>
                <flux:input wire:model="stream_name" id="stream_name" type="text" placeholder="e.g. Science Stream" />
                <flux:error name="stream_name" />
            </flux:field>
            
            <flux:field>
                <flux:label for="description">Description</flux:label>
                <flux:textarea wire:model="description" id="description" placeholder="Describe the stream..." rows="4" />
                <flux:error name="description" />
            </flux:field>
        </div>

        <div class="flex justify-end space-x-3">
            <flux:button href="{{ route('admin.streams.index') }}" variant="filled">Cancel</flux:button>
            <flux:button type="submit" variant="primary">{{ $isEdit ? 'Update Stream' : 'Create Stream' }}</flux:button>
        </div>
    </form>
</div> 
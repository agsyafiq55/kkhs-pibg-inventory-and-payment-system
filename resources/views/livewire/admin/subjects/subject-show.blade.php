<div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <flux:heading size="lg" class="mb-4">Subject Details</flux:heading>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <flux:text class="text-sm text-gray-500">Subject Code</flux:text>
                        <flux:text class="font-medium">{{ $subject->subject_code }}</flux:text>
                    </div>
                    
                    <div>
                        <flux:text class="text-sm text-gray-500">Subject Name</flux:text>
                        <flux:text class="font-medium">{{ $subject->subject_name }}</flux:text>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <flux:text class="text-sm text-gray-500">Type</flux:text>
                        <flux:badge color="{{ $subject->type === 'core' ? 'blue' : 'amber' }}">
                            {{ ucfirst($subject->type) }}
                        </flux:badge>
                    </div>
                    
                    <div>
                        <flux:text class="text-sm text-gray-500">For Muslim Only</flux:text>
                        <flux:badge color="{{ $subject->for_muslim_only ? 'emerald' : 'gray' }}">
                            {{ $subject->for_muslim_only ? 'Yes' : 'No' }}
                        </flux:badge>
                    </div>
                    
                    <div>
                        <flux:text class="text-sm text-gray-500">For Non-Muslim Only</flux:text>
                        <flux:badge color="{{ $subject->for_non_muslim_only ? 'purple' : 'gray' }}">
                            {{ $subject->for_non_muslim_only ? 'Yes' : 'No' }}
                        </flux:badge>
                    </div>
                </div>
                
                <div>
                    <flux:text class="text-sm text-gray-500">Created At</flux:text>
                    <flux:text>{{ $subject->created_at->format('d M Y, h:i A') }}</flux:text>
                </div>
                
                <div>
                    <flux:text class="text-sm text-gray-500">Last Updated</flux:text>
                    <flux:text>{{ $subject->updated_at->format('d M Y, h:i A') }}</flux:text>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow">
            <flux:heading size="lg" class="mb-4">Associated Items</flux:heading>
            
            @if($items->count() > 0)
                <div class="space-y-4">
                    @foreach($items as $item)
                        <div class="border border-gray-200 rounded p-3 flex justify-between items-center">
                            <div>
                                <flux:text class="font-medium">{{ $item->item_name }}</flux:text>
                                <flux:text class="text-sm text-gray-500">{{ $item->item_code }}</flux:text>
                            </div>
                            <flux:button href="{{ route('admin.items.show', $item) }}" variant="filled" size="xs">View</flux:button>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            @else
                <flux:callout icon="information-circle">
                    <flux:callout.text>No items are associated with this subject.</flux:callout.text>
                </flux:callout>
            @endif
        </div>
    </div>
</div> 
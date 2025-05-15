<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <flux:heading size="lg">Import Students for {{ $classroom->class_name }}</flux:heading>
            <flux:text class="mt-2">Upload a CSV file containing student information for the academic year.</flux:text>
        </div>
        
        <div class="p-6">
            <form wire:submit="import" class="space-y-6">
                <flux:callout icon="information-circle">
                    <flux:callout.heading>CSV Format Guidelines</flux:callout.heading>
                    <flux:callout.text>
                        Your CSV file should have the following columns in order:<br>
                        <code>name,daftar_no,ic_no,gender,islam,previous_school,scholarship</code><br><br>
                        The first row should be the header row. For boolean fields (islam, scholarship), use "Yes/No" or "True/False".
                    </flux:callout.text>
                </flux:callout>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label for="academic_year">Academic Year</flux:label>
                        <flux:input type="number" id="academic_year" wire:model="academic_year" min="2000" max="2100" />
                        <flux:description>The academic year these students will be assigned to this class.</flux:description>
                        <flux:error name="academic_year" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label for="csvFile">Upload CSV File</flux:label>
                        <input type="file" id="csvFile" wire:model="csvFile" accept=".csv,.txt" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none p-2.5" />
                        <flux:error name="csvFile" />
                    </flux:field>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <flux:button as="a" href="{{ route('admin.classrooms.show', $classroom->class_id) }}">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="import">Import Students</span>
                        <span wire:loading wire:target="import">Importing...</span>
                    </flux:button>
                </div>
            </form>
            
            @if(session('message'))
                <div class="mt-6">
                    <flux:callout icon="check-circle" class="bg-green-50">
                        <flux:callout.text>{{ session('message') }}</flux:callout.text>
                    </flux:callout>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mt-6">
                    <flux:callout icon="x-circle" class="bg-red-50">
                        <flux:callout.text>{{ session('error') }}</flux:callout.text>
                    </flux:callout>
                </div>
            @endif
            
            @if($showResults)
                <div class="mt-6">
                    <flux:heading size="lg">Import Results</flux:heading>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <flux:heading>{{ $importedCount }} Students Imported</flux:heading>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <flux:heading>{{ $errorCount }} Errors</flux:heading>
                        </div>
                    </div>
                    <div class="mt-4">
                        <flux:button as="a" href="{{ route('admin.classrooms.show', $classroom->class_id) }}" variant="primary">
                            Return to Class
                        </flux:button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div> 
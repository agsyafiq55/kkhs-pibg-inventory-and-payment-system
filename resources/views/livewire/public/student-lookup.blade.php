<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 my-4">
    @if ($error)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endif

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4 dark:text-white">Student Package Lookup</h2>
        <p class="text-gray-600 dark:text-gray-300 mb-4">Please enter your Daftar Number and IC Number to view and pay for your classroom package.</p>
        
        <form wire:submit="lookup" class="space-y-4">
            <flux:field>
                <flux:label for="daftarNo">Daftar Number</flux:label>
                <flux:input id="daftarNo" wire:model="daftarNo" />
                <flux:error name="daftarNo" />
            </flux:field>
            
            <flux:field>
                <flux:label for="icNumber">IC Number</flux:label>
                <flux:input id="icNumber" wire:model="icNumber" />
                <flux:error name="icNumber" />
            </flux:field>
            
            <div class="flex items-center justify-between">
                <flux:button type="submit" variant="primary">Look Up</flux:button>
                
                @if($student)
                    <flux:button type="button" variant="filled" wire:click="resetForm">Reset</flux:button>
                @endif
            </div>
        </form>
    </div>
    
    @if($student && $package && !$error)
        <div class="border-t border-gray-200 pt-4 mt-4">
            <h3 class="text-lg font-semibold mb-2 dark:text-white">Student Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Name: <span class="font-medium text-gray-900 dark:text-white">{{ $student->name }}</span></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Class: <span class="font-medium text-gray-900 dark:text-white">{{ $student->classroom->class_name }}</span></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Form: <span class="font-medium text-gray-900 dark:text-white">{{ $student->form }}</span></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Daftar No: <span class="font-medium text-gray-900 dark:text-white">{{ $student->daftar_no }}</span></p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">IC No: <span class="font-medium text-gray-900 dark:text-white">{{ $student->ic_no }}</span></p>
                </div>
            </div>
            
            <h3 class="text-lg font-semibold mb-2 mt-4 dark:text-white">Package Information</h3>
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md mb-4">
                <h4 class="font-medium text-gray-900 dark:text-white">{{ $package->package_name }}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $package->description }}</p>
                <div class="mt-2">
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Items in package:</span>
                    <ul class="list-disc list-inside ml-2 mt-1">
                        @foreach($package->items as $item)
                            <li class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $item->variant->item->name }} ({{ $item->quantity }}) - RM{{ number_format($item->total_price, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-900 dark:text-white">Total: RM{{ number_format($package->total_price, 2) }}</span>
                    <flux:button as="a" variant="success" href="{{ route('public.payment', ['studentId' => $student->student_id, 'packageId' => $package->package_id]) }}">
                        Proceed to Payment
                    </flux:button>
                </div>
            </div>
        </div>
    @endif
</div>

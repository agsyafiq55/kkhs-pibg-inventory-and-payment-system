<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 my-4">
    <h2 class="text-xl font-semibold mb-4 dark:text-white">Payment Process</h2>

    @if ($paymentError)
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ $paymentError }}</span>
            <a href="{{ route('home') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Back to Home
            </a>
        </div>
    @elseif ($paymentSuccess)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">Your payment has been completed successfully.</span>
            <p class="mt-2">A confirmation email will be sent to your registered email address.</p>
            <a href="{{ route('home') }}" class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Back to Home
            </a>
        </div>
    @else
        <div class="mb-6">
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Order Summary</h3>
                
                <div class="flex justify-between items-center border-b border-gray-200 py-2">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $student->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-300">{{ $student->classroom->class_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $package->package_name }}</p>
                    </div>
                </div>
                
                <div class="py-2">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300">Items in package:</p>
                    <ul class="list-disc list-inside ml-2 mt-1">
                        @foreach($package->items as $item)
                            <li class="text-xs text-gray-600 dark:text-gray-300">
                                {{ $item->variant->item->name }} ({{ $item->quantity }}) - RM{{ number_format($item->total_price, 2) }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="flex justify-between items-center py-2 border-t border-gray-200">
                    <span class="text-base font-bold text-gray-900 dark:text-white">Total Amount:</span>
                    <span class="text-lg font-bold text-gray-900 dark:text-white">RM{{ number_format($package->total_price, 2) }}</span>
                </div>
            </div>
            
            <!-- Payment Form -->
            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment Information</h3>
                
                <!-- This is a placeholder for Stripe integration -->
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                    We'll integrate Stripe payment here. For now, use the test payment button below.
                </p>
                
                <div class="mt-4">
                    <button wire:click="processPayment" type="button" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <span wire:loading.remove wire:target="processPayment">Make Payment</span>
                        <span wire:loading wire:target="processPayment">
                            Processing...
                        </span>
                    </button>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

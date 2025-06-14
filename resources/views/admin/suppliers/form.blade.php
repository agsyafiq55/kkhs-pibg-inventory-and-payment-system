<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($supplier) ? __('Edit Supplier') : __('Add New Supplier') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($supplier))
                        <livewire:admin.suppliers.supplier-form :supplier="$supplier" />
                    @else
                        <livewire:admin.suppliers.supplier-form />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 
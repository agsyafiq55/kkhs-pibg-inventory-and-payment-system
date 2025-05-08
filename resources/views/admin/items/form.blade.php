<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($item) ? __('Edit Item') : __('Add New Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($item))
                        <livewire:admin.items.item-form :item="$item" />
                    @else
                        <livewire:admin.items.item-form />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 
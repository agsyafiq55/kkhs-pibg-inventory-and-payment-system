<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Package Item') }}: {{ $package->package_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:admin.packages.package-item-form :package="$package" :itemId="$item->package_item_id" />
        </div>
    </div>
</x-layouts.app> 
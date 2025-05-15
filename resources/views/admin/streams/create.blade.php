<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <flux:heading>Create New Stream</flux:heading>
            <flux:breadcrumbs>
                <flux:breadcrumbs.item href="{{ route('dashboard') }}">Dashboard</flux:breadcrumbs.item>
                <flux:breadcrumbs.item href="{{ route('admin.streams.index') }}">Streams</flux:breadcrumbs.item>
                <flux:breadcrumbs.item>Create</flux:breadcrumbs.item>
            </flux:breadcrumbs>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:admin.streams.stream-form />
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 
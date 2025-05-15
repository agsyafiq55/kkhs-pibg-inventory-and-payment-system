<x-layouts.app>
    <x-slot name="header">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.subjects.index') }}">Subjects</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Add Subject</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:heading class="mt-2">Add New Subject</flux:heading>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('error'))
                        <flux:callout icon="exclamation-triangle" class="mb-4" color="red">
                            <flux:callout.text>{{ session('error') }}</flux:callout.text>
                        </flux:callout>
                    @endif
                    
                    <livewire:admin.subjects.subject-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
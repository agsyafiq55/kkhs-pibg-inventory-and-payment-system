<x-layouts.app>
    <x-slot name="header">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.subjects.index') }}">Subjects</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ $subject->subject_code }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <div class="flex justify-between items-center mt-2">
            <flux:heading>{{ $subject->subject_name }}</flux:heading>
            <div class="flex space-x-2">
                <flux:button href="{{ route('admin.subjects.edit', $subject) }}" variant="filled">Edit</flux:button>
                <flux:button href="{{ route('admin.subjects.index') }}" variant="filled">Back to List</flux:button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <livewire:admin.subjects.subject-show :subject="$subject" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
<x-layouts.app>
    <div class="relative mb-6 w-full">
        <div class="flex justify-between items-center mb-4">
            <div>
                <flux:heading size="xl" level="1">{{ __('Student Management') }}</flux:heading>
                <flux:subheading size="lg">{{ __('Manage students and their information') }}</flux:subheading>
            </div>
        </div>
        <flux:separator variant="subtle" class="mb-6" />
    </div>
    <livewire:admin.students.student-list />
</x-layouts.app>
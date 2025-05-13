<x-layouts.app>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Student Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage students and their information') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:admin.students.student-list />
</x-layouts.app>
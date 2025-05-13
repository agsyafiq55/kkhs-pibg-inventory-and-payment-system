<x-layouts.app>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Manage Classrooms') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage classrooms and their students') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:admin.class-rooms.class-room-list />
</x-layouts.app>
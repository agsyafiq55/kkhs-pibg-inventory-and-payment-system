<x-layouts.app>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Manage Inventory') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage items and their information') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:admin.items.item-list />
</x-layouts.app>
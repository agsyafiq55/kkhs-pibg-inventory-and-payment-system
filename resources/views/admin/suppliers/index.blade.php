<x-layouts.app>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Supplier Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage suppliers and their information') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:admin.suppliers.supplier-list />
</x-layouts.app>
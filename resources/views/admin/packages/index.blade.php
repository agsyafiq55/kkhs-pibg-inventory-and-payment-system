<x-layouts.app>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Packages Management') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage packages and their information') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:admin.packages.package-list />
</x-layouts.app>
<x-layouts.app>
    @if(isset($item))
    <livewire:admin.items.item-form :item="$item" />
    @else
    <livewire:admin.items.item-form />
    @endif
</x-layouts.app>
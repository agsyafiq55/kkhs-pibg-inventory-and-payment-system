<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($classroom) ? __('Edit Class') : __('Add New Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(isset($classroom))
                        <livewire:admin.class-rooms.class-room-form :classroom="$classroom" />
                    @else
                        <livewire:admin.class-rooms.class-room-form />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app> 
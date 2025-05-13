<x-layouts.app :title="__('Student Payment')">
    <div class="max-w-3xl mx-auto py-12 sm:px-6 lg:px-8">
        <livewire:public.payment-processor :studentId="$studentId" :packageId="$packageId" />
    </div>
</x-layouts.app> 
<x-layouts.app :title="'KKHS PIBG - Student Payment System'">
    <div class="max-w-3xl mx-auto py-12 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h2 class="text-xl font-semibold mb-4">Welcome to KKHS PIBG Student Package System</h2>
                <p class="mb-4">Our online platform enables parents and students to easily view and pay for their classroom supply packages.</p>
                <p>Please enter your student information below to view available packages and make a payment.</p>
            </div>
        </div>
        
        <!-- Student Lookup Form Component -->
        <livewire:public.student-lookup />
    </div>
</x-layouts.app>

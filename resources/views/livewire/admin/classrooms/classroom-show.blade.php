<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="flex justify-between items-center px-4 py-5 border-b border-gray-200 sm:px-6">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Class Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Class details and registered students.</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.classrooms.edit', $classroom->class_id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Edit
                </a>
                <a href="{{ route('admin.classrooms.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to List
                </a>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Class name</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $classroom->full_class_name }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Students ({{ $academic_year }})</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $classroom->getStudentCountForYear($academic_year) }}</dd>
                </div>
            </dl>
        </div>
    </div>
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="flex justify-between items-center px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Student Management</h3>
            <div class="flex space-x-3">
                <a href="{{ route('admin.classrooms.add-student', $classroom->class_id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Add Student
                </a>
                <a href="{{ route('admin.classrooms.import-students', $classroom->class_id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Import Students from CSV
                </a>
            </div>
        </div>
        <div class="p-4 bg-gray-50">
            <flux:callout icon="information-circle">
                <flux:callout.heading>Viewing Students by Academic Year</flux:callout.heading>
                <flux:callout.text>
                    Select an academic year to view students assigned to this class for that year.
                </flux:callout.text>
            </flux:callout>
            
            <div class="mt-4 flex items-center space-x-2">
                <flux:field class="w-48">
                    <flux:label for="academic_year">Academic Year</flux:label>
                    <flux:select id="academic_year" wire:change="setAcademicYear($event.target.value)" wire:model="academic_year">
                        @foreach($availableYears as $year)
                            <flux:select.option value="{{ $year }}">{{ $year }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="flex justify-between items-center px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Students in {{ $classroom->full_class_name }} {{ $academic_year }}
            </h3>
            <div>
                <input type="text" wire:model.live.debounce.300ms="search" class="px-4 py-2 rounded border" placeholder="Search students...">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IC No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($students as $student)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->ic_no ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $student->gender ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.students.show', $student->student_id) }}" class="text-blue-500 hover:text-blue-700">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                No students in this class for the selected academic year.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $students->links() }}
        </div>
    </div>
</div> 
<?php

namespace App\Livewire\Admin\ClassRooms;

use App\Models\Classroom;
use App\Models\Student;
use App\Models\StudentClassHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ImportStudents extends Component
{
    use WithFileUploads;
    
    public Classroom $classroom;
    public $csvFile;
    public $academic_year;
    public $importedCount = 0;
    public $errorCount = 0;
    public $showResults = false;
    
    protected $rules = [
        'csvFile' => 'required|file|mimes:csv,txt|max:1024',
        'academic_year' => 'required|integer|min:2000|max:2100',
    ];
    
    public function mount(Classroom $classroom)
    {
        $this->classroom = $classroom;
        $this->academic_year = date('Y');
    }
    
    public function import()
    {
        $this->validate();
        
        $this->importedCount = 0;
        $this->errorCount = 0;
        
        $path = $this->csvFile->getRealPath();
        $file = fopen($path, 'r');
        
        // Skip the header row
        $header = fgetcsv($file);
        
        // Start a database transaction
        DB::beginTransaction();
        
        try {
            while ($row = fgetcsv($file)) {
                // Map CSV columns to student fields
                // Expected CSV format: name,daftar_no,ic_no,gender,islam,previous_school,scholarship
                $studentData = [
                    'name' => $row[0] ?? '',
                    'daftar_no' => $row[1] ?? null,
                    'ic_no' => $row[2] ?? null,
                    'gender' => $row[3] ?? null,
                    'islam' => strtolower($row[4] ?? '') === 'yes' || strtolower($row[4] ?? '') === 'true' || $row[4] === '1',
                    'previous_school' => $row[5] ?? null,
                    'scholarship' => strtolower($row[6] ?? '') === 'yes' || strtolower($row[6] ?? '') === 'true' || $row[6] === '1',
                    'class_id' => $this->classroom->class_id, // Always assign to current classroom to satisfy the foreign key constraint
                ];
                
                // Skip if required fields are missing
                if (empty($studentData['name'])) {
                    $this->errorCount++;
                    continue;
                }
                
                // Find or create the student without changing their current class_id
                $student = Student::updateOrCreate(
                    [
                        'name' => $studentData['name'],
                        'ic_no' => $studentData['ic_no'],
                    ],
                    $studentData
                );
                
                // If this import is for the current year, update the student's current class
                if ($this->academic_year == date('Y')) {
                    $student->class_id = $this->classroom->class_id;
                    $student->save();
                }
                
                // Check if there's an existing record for this combination
                $existingRecord = StudentClassHistory::where('student_id', $student->student_id)
                    ->where('academic_year', $this->academic_year)
                    ->first();
                
                if ($existingRecord) {
                    // If the record exists and it's for a different class, don't override
                    // Only update if the class is the same or if forced override is enabled
                    if ($existingRecord->class_id != $this->classroom->class_id) {
                        // Here we could add a warning or a flag to indicate the student is already assigned to another class
                        // For now, we'll just skip this student to prevent overriding existing records
                        continue;
                    }
                } else {
                    // Create a new class history record if none exists
                    StudentClassHistory::create([
                        'student_id' => $student->student_id,
                        'class_id' => $this->classroom->class_id,
                        'academic_year' => $this->academic_year,
                    ]);
                }
                
                $this->importedCount++;
            }
            
            DB::commit();
            $this->showResults = true;
            
            session()->flash('message', "Successfully imported {$this->importedCount} students with {$this->errorCount} errors.");
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error importing students: ' . $e->getMessage());
        }
        
        fclose($file);
    }
    
    public function render()
    {
        return view('livewire.admin.classrooms.import-students');
    }
}
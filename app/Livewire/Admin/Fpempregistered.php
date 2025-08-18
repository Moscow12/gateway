<?php

namespace App\Livewire\Admin;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeesFPImport;
use App\Models\Fpregisteredemp;
use Livewire\Component;
use Livewire\WithPagination;

class Fpempregistered extends Component
{
    public $fpRegisteredEmps;
    use WithPagination;
    use WithFileUploads;
    protected $listeners = ['refreshFpEmpRegistered' => 'mount'];
    public ?TemporaryUploadedFile $excelFile = null; // IMPORTANT for v3

    public function render()
    {
        return view('livewire.admin.fpempregistered');
    }

    public function mount()
    {
        $this->fpRegisteredEmps = Fpregisteredemp::paginate(0)->toArray();
        
    }

    public function uploadExcel(){
        #submit data from excel file
        $this->validate([
            'excelFile' => 'required|mimes:xlsx,xls,csv|max:2048', // 2MB
        ]);

        $tempPath = $this->excelFile->storeAs(
            'uploads',
            uniqid() . '.' . $this->excelFile->getClientOriginalExtension()
        );

        // Move file to a safe permanent location
        $storedPath = $this->excelFile->storeAs('uploads', $this->excelFile->getClientOriginalName()       );
        
       
        // Import using Laravel Excel
        Excel::import(new EmployeesFPImport, storage_path('/' . $tempPath));

        session()->flash('message', 'Excel uploaded successfully!');
    }
}

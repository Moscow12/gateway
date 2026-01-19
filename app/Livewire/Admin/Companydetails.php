<?php

namespace App\Livewire\Admin;

use App\Models\companydetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Companydetails extends Component
{
    use WithFileUploads;

    public $companyId;
    public $isEditMode = false;
    public $hasExistingData = false;

    // Form fields
    public $company_name;
    public $address;
    public $phone;
    public $email;
    public $fax;
    public $tax_number;
    public $vat_number;
    public $iban;
    public $swift_bic;
    public $bank_name;
    public $bank_account;
    public $bank_address;
    public $website;
    public $logo;
    public $existing_logo;

    public function mount()
    {
        $this->loadCompanyDetails();
    }

    public function loadCompanyDetails()
    {
        $company = companydetail::first();

        if ($company) {
            $this->hasExistingData = true;
            $this->companyId = $company->id;
            $this->company_name = $company->company_name;
            $this->address = $company->address;
            $this->phone = $company->phone;
            $this->email = $company->email;
            $this->fax = $company->fax;
            $this->tax_number = $company->tax_number;
            $this->vat_number = $company->vat_number;
            $this->iban = $company->iban;
            $this->swift_bic = $company->swift_bic;
            $this->bank_name = $company->bank_name;
            $this->bank_account = $company->bank_account;
            $this->bank_address = $company->bank_address;
            $this->website = $company->website;
            $this->existing_logo = $company->logo;
        }
    }

    public function enableEdit()
    {
        $this->isEditMode = true;
    }

    public function cancelEdit()
    {
        $this->isEditMode = false;
        $this->logo = null;
        $this->loadCompanyDetails();
    }

    public function save()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'fax' => 'nullable|string|max:20',
            'tax_number' => 'nullable|string|max:50',
            'vat_number' => 'nullable|string|max:50',
            'iban' => 'nullable|string|max:50',
            'swift_bic' => 'nullable|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_address' => 'nullable|string|max:500',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = [
            'company_name' => $this->company_name,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'fax' => $this->fax,
            'tax_number' => $this->tax_number,
            'vat_number' => $this->vat_number,
            'iban' => $this->iban,
            'swift_bic' => $this->swift_bic,
            'bank_name' => $this->bank_name,
            'bank_account' => $this->bank_account,
            'bank_address' => $this->bank_address,
            'website' => $this->website,
            'user_id' => Auth::id(),
        ];

        // Handle logo upload
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
            $data['logo'] = $logoPath;
        }

        if ($this->hasExistingData && $this->companyId) {
            $company = companydetail::find($this->companyId);
            $company->update($data);
            session()->flash('message', 'Company details updated successfully.');
        } else {
            companydetail::create($data);
            session()->flash('message', 'Company details saved successfully.');
        }

        $this->isEditMode = false;
        $this->logo = null;
        $this->loadCompanyDetails();
    }

    public function render()
    {
        return view('livewire.admin.companydetails');
    }
}

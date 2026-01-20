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

    // Social Media Links
    public $facebook;
    public $twitter;
    public $instagram;
    public $linkedin;
    public $youtube;
    public $tiktok;
    public $github;

    // Working Hours
    public $working_hours_weekdays;
    public $working_hours_saturday;
    public $working_hours_sunday;

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

            // Social Media Links
            $this->facebook = $company->facebook;
            $this->twitter = $company->twitter;
            $this->instagram = $company->instagram;
            $this->linkedin = $company->linkedin;
            $this->youtube = $company->youtube;
            $this->tiktok = $company->tiktok;
            $this->github = $company->github;

            // Working Hours
            $this->working_hours_weekdays = $company->working_hours_weekdays;
            $this->working_hours_saturday = $company->working_hours_saturday;
            $this->working_hours_sunday = $company->working_hours_sunday;
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
            // Social Media Links (nullable URLs)
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'tiktok' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            // Working Hours (nullable strings)
            'working_hours_weekdays' => 'nullable|string|max:100',
            'working_hours_saturday' => 'nullable|string|max:100',
            'working_hours_sunday' => 'nullable|string|max:100',
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
            // Social Media Links
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'youtube' => $this->youtube,
            'tiktok' => $this->tiktok,
            'github' => $this->github,
            // Working Hours
            'working_hours_weekdays' => $this->working_hours_weekdays,
            'working_hours_saturday' => $this->working_hours_saturday,
            'working_hours_sunday' => $this->working_hours_sunday,
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

<?php

namespace App\Http\Controllers;

use App\Models\Jobapplications;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index(){ 
        return view('frontend.master');
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function about(){
        return view('frontend.about');
    }

    public function events(){
        
        return view('frontend.events');
    }

    public function gallery(){
        return view('frontend.gallery');
    }

    

    public function applicationform(Request $request){
     
        $validatedData = $request->validate([
            'ApplicantName' => 'required|string',
            'ApplicantEmail' => 'required|email',
            'phone' => 'required|string',
            'Gender' => 'required|in:Male,Female,Other',
            'MaritalStatus' => 'required|string',
            'Nida' => 'nullable',
            'dob' => 'required|date',
            'Location' => 'required|string',
    
            // File validation
            'fourFourCert' => ['nullable',  'max:2048'],
            'internshipCert' => ['nullable',  'max:2048'],
            'birthCert' => ['nullable',  'max:2048'],            
            'sixCertificate' => ['nullable',  'max:2048'],
            'mctCertificate' => ['nullable',  'max:2048'],
            'license' => ['nullable',  'max:2048'],
            'CariculumVitae' => ['nullable',  'max:2048'],
            'collageCert' => ['nullable',  'max:2048'],
            'applicationLetter' => ['nullable',  'max:2048'],
        ]);
    
                // Handle file uploads efficiently
        $fileFields = [
            'fourFourCert','applicationLetter', 'internshipCert', 'birthCert', 'sixCertificate', 
            'mctCertificate', 'license', 'CariculumVitae', 'collageCert'
        ];

        foreach ($fileFields as $fileField) {
            if ($request->hasFile($fileField)) {
                $validatedData[$fileField] = $request->file($fileField)->store('uploads', 'public');
            }
        }

        // Insert into the database
        Jobapplications::create($validatedData);

        // Process the data (store in database, send email, etc.)
        return back()->with('success_message', 'Application submitted successfully!');
    }
}

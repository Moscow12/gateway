<?php

namespace App\Livewire\Admin;

use App\Models\Clients;
use App\Models\Smscategories;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Str;
use function Laravel\Prompts\alert;

class Client extends Component
{
    public $clients = [], $selectedClients = [], $selectAll = false, $client_s, $clientId;
    public $search = '', $categories;  
    public $isEditMode = false; 
    public $clientname, $clientemail, $clientphone, $clientaddress, $clientcity, $clientcountry, $clientcode;

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditMode = true;
            $this->client_s = Clients::findOrFail($id);
            $this->clientId = $id;
            $this->clientname = $this->client_s->clientname;
            $this->clientemail = $this->client_s->clientemail;
            $this->clientphone = $this->client_s->clientphone;
            $this->clientaddress = $this->client_s->clientaddress;
            $this->clientcity = $this->client_s->clientcity;
            $this->clientcountry = $this->client_s->clientcountry;
            $this->categories = Smscategories::all();
        }
        $this->clients = Clients::all();
        $this->categories = Smscategories::all();

    }
    public function render()
    {
        return view('livewire.admin.client');
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedClients = $this->client_s->pluck('id')->toArray();
        } else {
            $this->selectedClients = [];
        }
    }

    public function updatedSelectedClients($id)
    {
        $this->selectAll = count($this->selectedClients) === $this->client_s->count();
    }
   

    public function clientform(){
        $this->validate([
            'clientname' => 'required|string|max:255',
            'clientemail' => 'required|string|email|max:255',
            'clientphone' => 'required|regex:/^0[1-9][0-9]{8}$/',           
        ], ['clientphone.regex' => 'Phone must start with 0 and be exactly 10 digits. e.g 0756077533',]);
        $this->clientcode = Str::random(4).Date::now()->format('M').Date::now()->format('d').Date::now()->format('y');
        if ($this->isEditMode) {
            $client = Clients::findOrFail($this->clientId);
            $client->update([
                'clientname' => $this->clientname,
                'clientemail' => $this->clientemail,
                'clientphone' => $this->clientphone,
                'clientaddress' => $this->clientaddress,
                'clientcity' => $this->clientcity,
                'clientcode' => Str::upper($this->clientcode),
                'clientcountry' => $this->clientcountry,
            ]);
            session()->flash('message', 'Client updated successfully.');
            $this->reset(['clientname', 'clientemail', 'clientphone', 'clientaddress', 'clientcity', 'clientcountry', 'isEditMode']);
            $this->listclients();
        }else{
            Clients::create([
                'clientname' => $this->clientname,
                'clientemail' => $this->clientemail,
                'clientphone' => $this->clientphone,
                'clientaddress' => $this->clientaddress,
                'clientcity' => $this->clientcity,
                'clientcode' => Str::upper($this->clientcode),
                'clientcountry' => $this->clientcountry,
                'added_by' => Auth::user()->id
            ]);
            session()->flash('message', 'Client added successfully.');        
            $this->reset(['clientname', 'clientemail', 'clientphone', 'clientaddress', 'clientcity', 'clientcountry']);
            $this->listclients();
        }
    }
    public function listclients()
    {
        $this->clients = Clients::all();
    }

    public function delete($id)
    {
        $item = Clients::find($id);
        if ($item) {
            $item->delete();
            $this->clients = Clients::all(); // Refresh list
        }
    }
}

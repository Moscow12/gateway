<?php

namespace App\Livewire\Admin;

use App\Models\Producties;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Products extends Component
{
    public $productname, $initialprice, $topprice, $paymenttype, $productdescription, $products, $selectedProducts, $selectAll, $product_s, $productId;
    public $search = '', $categories;  
    public $isEditMode = false; 

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditMode = true;
            $this->product_s = Producties::findOrFail($id);
            $this->productId = $id;
            $this->productname = $this->product_s->productname;
            $this->initialprice = $this->product_s->initialprice;
            $this->topprice = $this->product_s->topprice;
            $this->paymenttype = $this->product_s->paymenttype;
            $this->productdescription = $this->product_s->productdescription;
        }
        $this->products = Producties::all();

    }
   
    public function render()
    {
        return view('livewire.admin.products');
    }

    public function addproduct()
    {
        $this->validate([
            'productname' => 'required|string|max:255',
            'initialprice' => 'required|string|max:255',
            'topprice' => 'required|string|max:255',
            'paymenttype' => 'required|string|max:255',
            'productdescription' => 'required|string|max:255',
        ], ['productname.regex' => 'Product name must start with 0 and be exactly 10 digits. e.g 0756077533',]);

        if ($this->isEditMode) {
            $product = Producties::findOrFail($this->productId);
            $product->update([
                'productname' => $this->productname,
                'initialprice' => $this->initialprice,
                'topprice' => $this->topprice,
                'paymenttype' => $this->paymenttype,
                'productdescription' => $this->productdescription,
            ]);
            session()->flash('message', 'Product updated successfully.');
            $this->reset();
            $this->listproducts();
        }else{
            Producties::create([
                'productname' => $this->productname,
                'initialprice' => $this->initialprice,
                'topprice' => $this->topprice,
                'paymenttype' => $this->paymenttype,
                'productdescription' => $this->productdescription,
                'added_by' => Auth::user()->id
            ]);
            session()->flash('message', 'Product added successfully.');        
            $this->reset();
            $this->listproducts();
        }
    }
    public function listproducts()
    {
        $this->products = Producties::all();
    }

    public function delete($id)
    {
        $item = Producties::find($id);
        if ($item) {
            $item->delete();
            $this->products = Producties::all(); // Refresh list
        }
    }   
}

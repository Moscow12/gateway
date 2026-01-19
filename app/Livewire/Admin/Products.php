<?php

namespace App\Livewire\Admin;

use App\Models\Producties;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;

    public $productname, $initialprice, $topprice, $paymenttype, $productdescription;
    public $productId;
    public $search = '';
    public $paymentTypeFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $isEditMode = false;

    protected $queryString = ['search', 'paymentTypeFilter'];

    protected function rules()
    {
        return [
            'productname' => 'required|string|max:255',
            'initialprice' => 'required|numeric|min:0',
            'topprice' => 'required|numeric|min:0',
            'paymenttype' => 'required|string|in:Recurring,One_Time_Payment,Other',
            'productdescription' => 'required|string|max:1000',
        ];
    }

    protected $messages = [
        'productname.required' => 'Product name is required.',
        'initialprice.required' => 'Initial price is required.',
        'initialprice.numeric' => 'Initial price must be a number.',
        'topprice.required' => 'Top price is required.',
        'topprice.numeric' => 'Top price must be a number.',
        'paymenttype.required' => 'Please select a payment type.',
        'productdescription.required' => 'Product description is required.',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPaymentTypeFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function editProduct($id)
    {
        $this->resetForm();
        $this->isEditMode = true;
        $product = Producties::findOrFail($id);
        $this->productId = $id;
        $this->productname = $product->productname;
        $this->initialprice = $product->initialprice;
        $this->topprice = $product->topprice;
        $this->paymenttype = $product->paymenttype;
        $this->productdescription = $product->productdescription;
    }

    public function saveProduct()
    {
        $this->validate();

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
        } else {
            Producties::create([
                'productname' => $this->productname,
                'initialprice' => $this->initialprice,
                'topprice' => $this->topprice,
                'paymenttype' => $this->paymenttype,
                'productdescription' => $this->productdescription,
                'added_by' => Auth::id()
            ]);
            session()->flash('message', 'Product added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function deleteProduct($id)
    {
        $product = Producties::find($id);
        if ($product) {
            $product->delete();
            session()->flash('message', 'Product deleted successfully.');
        }
    }

    public function resetForm()
    {
        $this->productId = null;
        $this->productname = '';
        $this->initialprice = '';
        $this->topprice = '';
        $this->paymenttype = '';
        $this->productdescription = '';
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->paymentTypeFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Producties::with('user');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('productname', 'like', '%' . $this->search . '%')
                  ->orWhere('productdescription', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->paymentTypeFilter) {
            $query->where('paymenttype', $this->paymentTypeFilter);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $products = $query->paginate(10);

        // Statistics
        $totalProducts = Producties::count();
        $recurringProducts = Producties::where('paymenttype', 'Recurring')->count();
        $oneTimeProducts = Producties::where('paymenttype', 'One_Time_Payment')->count();
        $avgPrice = Producties::avg('initialprice') ?? 0;

        return view('livewire.admin.products', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'recurringProducts' => $recurringProducts,
            'oneTimeProducts' => $oneTimeProducts,
            'avgPrice' => $avgPrice,
        ]);
    }
}

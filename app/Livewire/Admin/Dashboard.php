<?php

namespace App\Livewire\Admin;

use App\Models\Clients;
use App\Models\ClientService;
use App\Models\invoices;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class Dashboard extends Component
{
    // Revenue Statistics
    public $totalRevenue = 0;
    public $paidRevenue = 0;
    public $pendingRevenue = 0;
    public $monthlyRevenue = 0;

    // Service Statistics
    public $totalServices = 0;
    public $activeServices = 0;
    public $pendingServices = 0;
    public $expiredServices = 0;
    public $expiringSoonServices = 0;

    // Client Statistics
    public $totalClients = 0;
    public $activeClients = 0;

    // Recent Data
    public $recentInvoices = [];
    public $expiringSoonList = [];
    public $monthlyRevenueChart = [];

    public function logout()
    {
        Auth::logout();
        return $this->redirect('/login', navigate: true);
    }

    public function mount()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $this->loadRevenueStatistics();
        $this->loadServiceStatistics();
        $this->loadClientStatistics();
        $this->loadRecentInvoices();
        $this->loadExpiringSoonServices();
        $this->loadMonthlyRevenueChart();
    }

    public function loadRevenueStatistics()
    {
        // Total Revenue (all invoices)
        $this->totalRevenue = invoices::sum('TotalAmount') ?? 0;

        // Paid Revenue
        $this->paidRevenue = invoices::where('Status', 'paid')->sum('TotalAmount') ?? 0;

        // Pending Revenue (unpaid invoices)
        $this->pendingRevenue = invoices::whereIn('Status', ['pending', 'unpaid', null])
            ->orWhereNull('Status')
            ->sum('TotalAmount') ?? 0;

        // This Month's Revenue
        $this->monthlyRevenue = invoices::where('Status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('TotalAmount') ?? 0;
    }

    public function loadServiceStatistics()
    {
        $this->totalServices = ClientService::count();
        $this->activeServices = ClientService::active()->count();
        $this->pendingServices = ClientService::pending()->count();
        $this->expiredServices = ClientService::expired()->count();
        $this->expiringSoonServices = ClientService::expiringSoon(30)->count();
    }

    public function loadClientStatistics()
    {
        $this->totalClients = Clients::count();

        // Clients with at least one active service
        $this->activeClients = Clients::whereHas('services', function ($query) {
            $query->where('status', ClientService::STATUS_ACTIVE);
        })->count();
    }

    public function loadRecentInvoices()
    {
        $this->recentInvoices = invoices::with(['client', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function loadExpiringSoonServices()
    {
        $this->expiringSoonList = ClientService::with(['client', 'serviceType'])
            ->expiringSoon(30)
            ->orderBy('license_end_date', 'asc')
            ->limit(5)
            ->get();
    }

    public function loadMonthlyRevenueChart()
    {
        // Get revenue for the last 6 months
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = invoices::where('Status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('TotalAmount') ?? 0;

            $months->push([
                'month' => $date->format('M'),
                'revenue' => $revenue
            ]);
        }
        $this->monthlyRevenueChart = $months->toArray();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}

<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\ClientService;

class SeeBalance extends Component
{
    public float $balance;

    public function mount()
    {
        $this->balance = Auth::guard("client")->user()->balance;
    }

    public function render()
    {
        return view('livewire.see-balance');
    }
}

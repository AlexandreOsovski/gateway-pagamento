<?php

namespace App\Livewire\Components\Modals;

use App\Services\ClientService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\PolygonService;

class TradeCriptoModal extends Component
{
    private $clientService;
    public string $valueBRL;
    public string $valueUSD;

    public function __construct(ClientService $clientService)
    {
        $this->valueBRL = '';
        $this->valueUSD = '';
        $this->clientService = $clientService;
    }

    public function render()
    {
        return view('livewire.components.modals.exchange');
    }

    public function convertSold()
    {
        $polygon = new PolygonService();
        $this->valueUSD = $polygon->fetchPrice('BRL', 'USD', $this->valueBRL);
    }

    public function maxSold()
    {
        $client = $this->clientService->find(Auth::guard('client')->user()->id);
        $this->valueBRL = $client->balance;
        $this->convertSold();
    }

    public function updated($property, $value)
    {
        if ($property == 'valueBRL') {
            $this->convertSold();
        }else{
            $this->convertSold();
        }
    }

    public function convertBalance()
    {
        $client = $this->clientService->find(Auth::guard('client')->user()->id);

        if ($client->balance < $this->valueBRL) {
            toastr('Saldo insuficiente', 'error');
            return redirect()->back();
        }

        $client->balance_usdt += $this->valueUSD;
        $client->balance -= $this->valueBRL;
        $client->update();

        toastr('Operação realizada com sucesso', 'success');
        return redirect()->route('dashboard.get');
    }
}

<?php

namespace App\Livewire\Components\Modals;

use App\Http\Controllers\Services\PolygonService;
use App\Models\ClientModel;
use App\Models\MovementModel;
use App\Models\NotificationModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Exchange extends Component
{
    public string $valueBRL;
    public string $valueUSD;

    public function __construct()
    {
        $this->valueBRL = '';
        $this->valueUSD = '';
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
        $this->valueBRL = Auth::guard('client')->user()->balance;
        $this->convertSold();
    }

    public function updated($property, $value)
    {
        if ($property == 'valueBRL') {
            $this->convertSold();
        }
    }

    public function convertBalance()
    {
        $user = ClientModel::find(Auth::guard('client')->user()->id);

        if ($user->balance < $this->valueBRL) {
            toastr('Saldo insuficiente', "error");
            return;
        }

        $user->balance_usdt += $this->valueUSD;
        $user->balance -= $this->valueBRL;
        $user->save();

        MovementModel::create([
            'client_id' => $user->id,
            'type' => 'ENTRY',
            'type_movement' => 'CONVERSION',
            'amount' => $this->valueUSD,
            'description' => 'Conversão de BRL para USDT'
        ]);

        NotificationModel::create([
            'client_id' => $user->id,
            'title' => "CONVERSÃO CRIPTO",
            'body' => 'Conversão de BRL para USDT realizada com sucesso -BRL ' . $this->valueBRL . ', +USDT' . $this->valueUSD,
            'icon' => 'fa-solid fa-hand-holding-dollar'
        ]);

        toastr('Operação realizada com sucesso', 'success');
        return redirect()->route('dashboard.get');
    }
}

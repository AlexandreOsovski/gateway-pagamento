<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\{
    ClientService,
    NotificationService,
    TransferUserToUserService,
    MovementService,
};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferUserToUser extends Controller
{
    private $transferUserToUserService;
    private $notificationService;
    private $clientService;
    private $movementService;
    public function __construct(TransferUserToUserService $transferUserToUserService, NotificationService $notificationService, ClientService $clientService, MovementService $movementService)
    {
        $this->transferUserToUserService = $transferUserToUserService;
        $this->notificationService = $notificationService;
        $this->clientService = $clientService;
        $this->movementService = $movementService;
    }

    public function transfer(Request $request)
    {
        $user = Auth::guard("client")->user();

        try {
            if ($user->balance < $request->value) {
                toastr('Não foi possível realizar a transferência, saldo insuficiente', 'error');
                return redirect()->route('dashboard.get');
            }

            if (filter_var($request->code_or_email, FILTER_VALIDATE_EMAIL)) {
                $client_to_received = $this->clientService->findByEmail($request->code_or_email);
            } else {
                $client_to_received = $this->clientService->findByCode($request->code_or_email);
            }

            if ($client_to_received->uuid == $user->uuid || $client_to_received->email == $user->email) {
                toastr('Destinatário não encontrado.', 'error');
                return redirect()->back();
            }

            if (!$client_to_received) {
                toastr('Destinatário não encontrado.', 'error');
                return redirect()->back();
            }

            $movementExit = $this->movementService->create($user->id, 'EXIT', 'TRANSFER', $request->value, 'Transferência interna entre Usuários');
            $movementEntry = $this->movementService->create($client_to_received->id, 'ENTRY', 'TRANSFER', $request->value, 'Transferência interna entre Usuários');

            if (!$movementExit || !$movementEntry) {
                toastr('Falha ao criar movimento de transferencia.', 'error');
                return redirect()->back();
            }
            $data = [
                "client_receive_id" => $client_to_received->id,
                "amount" => (float)$request->value,
                "movement_entry_id" => $movementEntry,
                "movement_exit_id" => $movementExit,
            ];

            $transfer = $this->transferUserToUserService->create($data);

            if (!$transfer) {
                toastr('Falha ao criar a transferência.', 'error');
                return redirect()->back();
            }


            $newBalanceUser = (float)$user->balance - (float)$request->value;
            $newBalanceReceived = (float)$client_to_received->balance + (float)$request->value;
            $this->clientService->updateBalance($newBalanceUser, $user->id);
            $this->clientService->updateBalance($newBalanceReceived, $client_to_received->id);



            $this->notificationService->create(
                $user->id,
                'fa-solid fa-dollar-sign',
                'Transferência realizada',
                "Você realizou uma transferência no valor de R$ {$request->value} para {$client_to_received->name}."
            );

            $this->notificationService->create(
                $client_to_received->id,
                'fa-solid fa-dollar-sign',
                'Transferência recebida',
                "Você recebeu uma transferência no valor de R$ {$request->value} de {$user->name}."
            );

            toastr('Transferência realizada com sucesso', 'success');
            return redirect()->route('dashboard.get');
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            $this->notificationService->create(
                $client_to_received->id ?? null,
                'fa-solid fa-xmark',
                'Erro ao realizar a transferência',
                "Não foi possível realizar a transferência no valor de R$ {$request->value} para {$client_to_received->name}. $errorMessage"
            );

            toastr('Erro ao realizar a transferência. Por favor, verifique os detalhes e tente novamente.', 'error');
            return redirect()->route('dashboard.get');
        }
    }
}

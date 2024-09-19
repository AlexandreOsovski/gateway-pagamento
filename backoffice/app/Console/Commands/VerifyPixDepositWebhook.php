<?php

namespace App\Console\Commands;

use Illuminate\{
    Console\Command,
    Support\Facades\Log
};

use App\Models\{
    AdminModel,
    WebhookNotificationModel,
    PixApiModel,
    ClientModel,
    MovementModel,
    TransferUserToUserModel,
    KeysApiModel
};

class VerifyPixDepositWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verify-pix-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica pagamentos com base em notificações PIX';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando verificação de pagamentos com base em notificações...');

        // Abrir ou criar o arquivo de log
        $logFile = storage_path('logs/pix_webhook.log');
        $log = fopen($logFile, 'a');

        $webhooks = WebhookNotificationModel::all();
        $pixApi = new PixApiModel();
        $admin = AdminModel::find(1);

        foreach ($webhooks as $webhook) {
            $jsonData = json_decode($webhook->data, true);

            if (isset($jsonData['Status']) && $jsonData['Status'] === 'received') {
                $orderId = $jsonData['order_id'] ?? null;

                if ($orderId) {
                    $dataPixApi = $pixApi->where('order_id', $orderId)->first();

                    if ($dataPixApi && $dataPixApi->status == 'pending') {

                        $keysApi = KeysApi::where('appId', $dataPixApi->appId)->first();

                        if ($keysApi) {
                            $client = Client::where('id', $keysApi->client_id)->first();

                            $adminBalance = ($dataPixApi->amount * 20) / 100;
                            $admin->balance += $adminBalance;
                            $admin->save();

                            $this->payComission($admin->id, $client->id, $adminBalance);

                            $userBalance = $dataPixApi->amount - $adminBalance;
                            $client->balance += $userBalance;
                            $client->save();

                            $dataPixApi->status = "approved";
                            $dataPixApi->save();

                            $this->entryValues($client->id, 'PIX - Depósito', 'entry', $userBalance, 'Depósito PIX');

                            $this->info("Ordem $orderId verificada e processada com sucesso.");

                            fwrite($log, "Ordem $orderId verificada e processada com sucesso.\n");
                        } else {
                            $this->info("Ordem $orderId não pôde ser processada devido a chaves ausentes.");

                            fwrite($log, "Ordem $orderId não pôde ser processada devido a chaves ausentes.\n");
                        }
                    } else {

                        $statusJson = $jsonData['Status'];

                        $this->info("Ordem $orderId já foi processada ou não está pendente - Status $statusJson.");

                        fwrite($log, "Ordem $orderId já foi processada ou não está pendente - Status $statusJson.\n");
                    }
                }
            }
        }

        // Fechar o arquivo de log
        fclose($log);
    }

    /**
     * Registra um movimento financeiro.
     *
     * @param int $client_id O ID do cliente associado ao movimento.
     * @param string $type O tipo de movimento financeiro (por exemplo, 'entrada' ou 'saída').
     * @param string $type_movements O tipo específico de movimento (por exemplo, 'Depósito' ou 'Comissão').
     * @param float $amount O valor do movimento financeiro.
     * @param string $description Uma descrição do movimento financeiro.
     * @return null
     */
    public function entryValues($client_id, $type, $type_movements, $amount, $description)
    {
        $movement = new Movement();
        $movement->client_id = $client_id;
        $movement->type = $type;
        $movement->type_movement = $type_movements;
        $movement->amount = $amount;
        $movement->description = $description;
        $movement->save();
    }

    /**
     * Registra uma transferência de valor de um usuário para outro.
     *
     * @param int $client_id O ID do cliente que está fazendo o pagamento.
     * @param int $client_pay_id O ID do cliente que está recebendo o pagamento.
     * @param float $amount O valor da transferência.
     * @return void
     */
    public function payComission($client_id, $client_pay_id, $amount)
    {
        $transfer = new TransferUser();
        $transfer->client_id = $client_id;
        $transfer->client_pay_id = $client_pay_id;
        $transfer->amount = $amount;
        $transfer->save();
    }
}

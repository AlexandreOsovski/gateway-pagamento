<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\PixApiModel;

class PixCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $tokenModel;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $tokenModel)
    {
        $this->data = $data;
        $this->tokenModel = $tokenModel;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            PixApiModel::create([
                'client_uuid' => $this->data['client_uuid'],
                'txId' => $this->data['txId'],
                'order_id' => $this->data['order_id'],
                'token' => $this->data['token'],
                'appId' => $this->data['appId'],
                'external_reference' => $this->data['external_reference'],
                'amount' => $this->data['amount'],
                'status' => $this->data['status'],
                'url_webhook' => $this->data['url_webhook'],
                'qrcode' => $this->data['qrcode']
            ]);
        } catch (\Exception $e) {
            Log::channel('pix_create')->error('Failed to create PIX: ' . $e->getMessage() . ' - ' . $this->tokenModel);
        }
    }
}

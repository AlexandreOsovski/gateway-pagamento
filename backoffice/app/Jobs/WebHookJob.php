<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebHookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    private $url;
    private $urlBotft;

    public function __construct($data, $url, $urlBotft)
    {
        $this->data = $data;
        $this->url = $url;
        $this->urlBotft = $urlBotft;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Http::post($this->url, $this->data);
            Log::channel('webhook')->info('Webhook sent successfully');
        } catch (\Exception $e) {
            Log::channel('webhook')->error('Failed to send webhook: ' . $e->getMessage());
        }

        try {
            Http::post($this->urlBotft, $this->data);
            Log::channel('webhook')->info('Webhook sent successfully');
        } catch (\Exception $e) {
            Log::channel('webhook')->error('Failed to send webhook: ' . $e->getMessage());
        }
    }
}

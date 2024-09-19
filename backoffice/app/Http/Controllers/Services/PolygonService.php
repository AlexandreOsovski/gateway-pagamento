<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PolygonService extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = "qAg9KOf5UdrVqNIu3hj2zVlfjS_6VPey";
    }

    /**
     * Build the conversion path for Polygon API.
     *
     * This method constructs a URL for converting currency using the Polygon API.
     *
     * @param string $from The currency code to convert from (e.g., "USD").
     * @param string $to The currency code to convert to (e.g., "EUR").
     * @param int $amount The amount to convert.
     * @return string The constructed URL for the conversion request.
     */
    private function buildConversionPath($from, $to, $amount)
    {
        $url = "https://api.polygon.io/v1/conversion/";
        $url .= urlencode($from) . "/" . urlencode($to);
        $url .= "?amount=" . urlencode($amount);
        $url .= "&precision=2";
        $url .= "&apiKey=" . urlencode($this->apiKey);

        return $url;
    }


    /**
     * Fetch the price
     *
     * @param string $from
     * @param string $to
     * @param string $apiKey
     * @return float
     */
    public function fetchPrice($from, $to, $amount)
    {
        $retryCount = 0;
        $maxRetries = 3;
        $retryDelay = 5;

        while ($retryCount < $maxRetries) {
            try {
                $pathUsd = $this->buildConversionPath($from, $to, $amount);
                $response = Http::timeout(30)->get($pathUsd);

                if ($response->successful()) {
                    return $response->json()['converted'];
                }
            } catch (\Exception $e) {
                sleep($retryDelay);
                $retryCount++;
            }
        }
    }
}

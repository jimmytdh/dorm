<?php

namespace App\Services;

use GuzzleHttp\Client;

class InfoBipService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = env('INFOBIP_BASE_URL'); // Set your base URL
        $this->apiKey = env('INFOBIP_API_KEY');   // Set your API key
    }

    public function sendSMS($to, $message)
    {
        $url = $this->baseUrl . "/sms/1/text/single";
        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => 'App ' . $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'from' => 'InfoBipDemo',
                'to' => $to,
                'text' => $message,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}

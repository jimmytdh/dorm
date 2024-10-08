<?php

namespace App\Services;

use GuzzleHttp\Client;

class SemaphoreService
{
    protected $client;
    protected $apiKey;
    protected $senderName;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('SEMAPHORE_API_KEY');
        $this->senderName = env('SEMAPHORE_SENDER_NAME', 'SEMAPHORE');
    }

    public function sendSMS($to, $message)
    {
        //$url = "https://api.semaphore.co/api/v4/messages";
        $url = "https://semaphore.co/api/v4/messages";
        $response = $this->client->post($url, [
            'form_params' => [
                'apikey' => $this->apiKey,
                'number' => $to,
                'message' => $message,
                'sendername' => $this->senderName,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}

<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Whatsapp
{
    protected $apiUrl;
    protected $instanceId;

    public function __construct()
    {
        $this->apiUrl = 'http://localhost:3000'; // Change this to your actual Express server URL
    }

    /**
     * Send a WhatsApp notification using WhatsApp Web.js API.
     *
     * @param string $phone The recipient's phone number in international format (without "+").
     * @param string $message The message content.
     * @return array Response data.
     */
    public function sendMessageToPersonal(string $phone, string $message)
    {
        try {
            $response = Http::post("{$this->apiUrl}/send-message", [
                'number'   => $phone,
                'message' => $message,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }


    public function sendMessageToGroup(string $idGrup, array $params){
        try {
            $response = Http::post("{$this->apiUrl}/send-group", [
                'number'   => $idGrup,
                'date' => $params['date'],
                'time' => $params['time'],
                'type' => $params['type']
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
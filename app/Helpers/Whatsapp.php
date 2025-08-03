<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

/**
 * Class Whatsapp
 *
 * This class provides methods to send WhatsApp messages to personal numbers and groups
 * using the WhatsApp Web.js API.
 */
class Whatsapp
{
    /**
     * The base URL of the WhatsApp Web.js API server.
     *
     * @var string
     */
    protected $apiUrl;

    /**
     * Constructor for the Whatsapp class.
     *
     * Initializes the API URL for the WhatsApp Web.js server.
     */
    public function __construct()
    {
        $this->apiUrl = 'http://localhost:3500/api/'; // Change this to your actual Express server URL
    }

    /**
     * Send a WhatsApp message to a personal number.
     *
     * @param string $phone The recipient's phone number in international format (without "+").
     * @param string $message The content of the message to be sent.
     * @return array Response data from the API. Returns an array with 'status' and 'message' keys.
     *               On success, 'status' will be 'success' and 'message' will contain the API response.
     *               On failure, 'status' will be 'error' and 'message' will contain the error message.
     */
    public function sendMessageToPersonal(string $phone, string $message)
    {
        try {
            $response = Http::post("{$this->apiUrl}send-message", [
                'number'   => $phone,
                'message' => $message,
            ]);


            return $response->json([
                'status'  => 'success',
                'message' => 'Send Success',
            ]);
        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send a WhatsApp message to a group.
     *
     * @param string $idGrup The ID of the group to which the message will be sent.
     * @param array $params An associative array containing the message parameters:
     *                      - 'date' (string): The date associated with the message.
     *                      - 'time' (string): The time associated with the message.
     *                      - 'type' (string): The type of the message.
     * @return array Response data from the API. Returns an array with 'status' and 'message' keys.
     *               On success, 'status' will be 'success' and 'message' will contain the API response.
     *               On failure, 'status' will be 'error' and 'message' will contain the error message.
     */
    public function sendMessageToGroup(string $idGrup, array $params)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',

            ])->post("{$this->apiUrl}send-group", [
                'number' => $idGrup,
                'date'   => $params['date'] ?? now()->toDateString(),
                'time'   => $params['time'] ?? now()->format('H:i'),
                'type'   => $params['type'] ?? 'text',
            ]);

            if ($response->successful()) {
                return [
                    'status'  => 'success',
                    'message' => 'Send Success',
                    'data'    => $response->json(),
                ];
            }

            return [
                'status'  => 'failed',
                'message' => $response->json('message') ?? 'Failed to send message',
                'code'    => $response->status(),
            ];
        } catch (\Throwable $e) {
            return [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}

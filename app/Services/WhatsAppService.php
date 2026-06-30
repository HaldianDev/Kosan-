<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected string $provider;
    protected ?string $token;
    protected ?string $sender;

    public function __construct()
    {
        $this->provider = config('services.whatsapp.provider', 'mock');
        $this->token = config('services.whatsapp.token');
        $this->sender = config('services.whatsapp.sender');
    }

    /**
     * Send a WhatsApp message.
     *
     * @param string $to
     * @param string $message
     * @return array ['success' => bool, 'message' => string, 'response' => mixed]
     */
    public function send(string $to, string $message): array
    {
        $formattedNumber = $this->formatPhoneNumber($to);

        if ($this->provider === 'mock' || empty($this->token)) {
            Log::info("WhatsApp Mock Broadcast Sent", [
                'to' => $formattedNumber,
                'message' => $message,
                'provider' => $this->provider,
            ]);

            return [
                'success' => true,
                'message' => '[Mock Mode] Message logged successfully.',
                'response' => null,
            ];
        }

        if ($this->provider === 'fonnte') {
            try {
                $payload = [
                    'target' => $formattedNumber,
                    'message' => $message,
                ];

                if (!empty($this->sender)) {
                    $payload['sender'] = $this->sender;
                }

                $response = Http::withHeaders([
                    'Authorization' => $this->token,
                ])->asForm()->post('https://api.fonnte.com/send', $payload);

                if ($response->successful()) {
                    $body = $response->json();
                    if (isset($body['status']) && $body['status'] == true) {
                        return [
                            'success' => true,
                            'message' => 'Message sent successfully via Fonnte.',
                            'response' => $body,
                        ];
                    }
                    return [
                        'success' => false,
                        'message' => $body['reason'] ?? 'Fonnte failed to process the request.',
                        'response' => $body,
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'HTTP request failed with status ' . $response->status(),
                    'response' => $response->body(),
                ];
            } catch (\Exception $e) {
                Log::error('WhatsApp Service Error (Fonnte): ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'Exception occurred: ' . $e->getMessage(),
                    'response' => null,
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Unsupported provider: ' . $this->provider,
            'response' => null,
        ];
    }

    /**
     * Formats phone numbers to 628... format.
     */
    public function formatPhoneNumber(string $phone): string
    {
        // Remove non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // If it starts with 08..., change to 628...
        if (str_starts_with($phone, '08')) {
            $phone = '628' . substr($phone, 2);
        }

        // If it starts with 8..., change to 628...
        if (str_starts_with($phone, '8') && !str_starts_with($phone, '82') && strlen($phone) >= 9) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}

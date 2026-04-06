<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    public function sendMessage($phone, $message)
    {
        $url = "https://api.z-api.io/instances/" 
            . config('services.zapi.instance') 
            . "/token/" 
            . config('services.zapi.token') 
            . "/send-text";

        $response = Http::withHeaders([
            'Client-Token' => config('services.zapi.client_token')
        ])->post($url, [
            "phone" => $this->formatPhone($phone),
            "message" => $message
        ]);

    }

    private function formatPhone($phone)
    {
        // remove tudo que não for número
        $phone = preg_replace('/\D/', '', $phone);

        // adiciona 55 (Brasil) se não tiver
        if (!str_starts_with($phone, '55')) {
            $phone = '55' . $phone;
        }

        return $phone;
    }
}
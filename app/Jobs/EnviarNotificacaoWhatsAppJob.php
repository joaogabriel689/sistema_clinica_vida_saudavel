<?php

namespace App\Jobs;

use App\Services\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviarNotificacaoWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 30;
    public array $backoff = [10, 30, 60];

    protected string $phone;
    protected string $message;
    protected ?int $clinicaId;

    /**
     * Create a new job instance.
     */
    public function __construct(string $phone, string $message, ?int $clinicaId = null)
    {
        $this->phone = preg_replace('/\D/', '', $phone);
        $this->message = trim(strip_tags($message));
        $this->clinicaId = $clinicaId;
    }

    /**
     * Execute the job.
     */
    public function handle(WhatsAppService $whatsAppService): void
    {
        if (empty($this->phone) || empty($this->message)) {
            return;
        }

        $whatsAppService->sendMessage($this->phone, $this->message, $this->clinicaId);
    }
}

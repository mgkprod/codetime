<?php

namespace App\Jobs;

use App\Exceptions\IncorrectWakaTimeResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ForwardHeartbeatJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $apiKey;
    public array $payloads;

    public function __construct(string $apiKey, array $payloads)
    {
        $this->apiKey = $apiKey;
        $this->payloads = $payloads;
    }

    public function handle()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($this->apiKey),
        ])->post('https://api.wakatime.com/users/current/heartbeats.bulk', $this->payloads);

        if (! in_array($response->status(), [200, 201, 202])) {
            throw new IncorrectWakaTimeResponse('Error processing WakaTime response. Expected response status to be 200, 201 or 202, got ' . $response->status());
        }
    }
}

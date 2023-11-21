<?php

namespace App\Services\SMS;

use Exception;
use Illuminate\Support\Facades\Log;

class Faraz
{
    private $client;
    private $from;
    private $pattern_code;

    public function __construct()
    {
        $this->client = new \IPPanel\Client(config('services.sms.farazsms.api_key'));
        $this->from = config('services.sms.farazsms.from');
        $this->pattern_code = config('services.sms.farazsms.pattern_code');
    }

    /**
     * Sends an OTP to the specified phone number using Faraz SMS service.
     *
     * @param string $phone The phone number to send the OTP to.
     * @param string $code The OTP code to send.
     * @return void
     */
    public function otpSend($phone, $code): bool
    {
        try {
            $messageId = $this->client->sendPattern(
                $this->pattern_code,
                $this->from,
                $phone,
                ['vcode' => $code]
            );
            return true;
        } catch(Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}

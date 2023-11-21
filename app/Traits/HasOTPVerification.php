<?php

namespace App\Traits;

use App\Exceptions\OTPSendLimitReachedException;
use App\Exceptions\OTPVerifyLimitReachedException;
use App\Models\OtpToken;
use App\Services\SMS\Faraz;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Cache;

trait HasOTPVerification
{
    public const OTP_SEND_LIMIT_PER_DAY = 5;
    public const OTP_ATTEMPT_LIMIT_PER_DAY = 10;

    public const OTP_CACHE_PREFIX = 'otp_attempts_';

    /**
     * Sends an SMS code to the specified phone number.
     *
     * @param string $phoneNumber The phone number to send the code to.
     * @return bool True if the code was sent successfully, false otherwise.
     * @throws Exception If the user has reached the daily or weekly limit.
     */
    public function sendOTPCode(): bool
    {
        // Check if the user has already sent 5 codes today
        $todaySentCount = $this->getSentCountForDay();
        if ($todaySentCount >= self::OTP_SEND_LIMIT_PER_DAY) {
            throw new OTPSendLimitReachedException();
        }

        // Generate a new code and insert it into the database
        $code = $this->generateCode();
        $sentAt = now();
        $this->otpTokens()->create([
            'code' => $code,
            'sent_at' => $sentAt,
            'phone' => $this->phone,
            'expires_at' => $sentAt->addMinutes(5),
        ]);

        return true;
        $sms = new Faraz();
        return $sms->otpSend($this->phone, $code);
    }

    /**
     * Verifies the specified SMS code.
     *
     * @param string $code The code to verify.
     * @param string $phone The phone number associated with the code.
     * @return bool True if the code is valid and not expired, false otherwise.
     */
    public function verifyOTPCode(string $code, string $phone): bool
    {
        $token = $this->otpTokens()
            ->wherePhone($phone)
            ->whereCode($code)
            ->notVerified()
            ->notExpired()
            ->first();

        if (!$token) {
            $attempts = $this->incrementOtpAttempts($phone);
            if ($attempts >= self::OTP_ATTEMPT_LIMIT_PER_DAY) {
                $this->expireOtpCodes();
                throw new OTPVerifyLimitReachedException();
            }
            return false;
        }

        // Reset the number of attempts made by the user
        $this->resetOtpAttempts($phone);
        $this->expireOtpCodes();

        $token->update(['verified_at' => now()]);

        return true;
    }

    /**
     * Gets the number of SMS codes sent by the user today.
     *
     * @return int The number of SMS codes sent by the user today.
     */
    private function getSentCountForDay(): int
    {
        return $this->otpTokens()
            ->sentToday()
            ->notVerified()
            ->count();
    }

    /**
     * Generates a new SMS code.
     *
     * @return string The new SMS code.
     */
    private function generateCode(): string
    {
        // Generate a random 6-digit code
        return strval(rand(100000, 999999));
    }

    /**
     * Get all of the user's OTP tokens.
     *
     * @return MorphMany
     */
    public function otpTokens(): MorphMany
    {
        return $this->morphMany(OtpToken::class, 'verifiable');
    }

    /**
     * Increments the number of OTP attempts for the specified phone number.
     *
     * @param string $phone The phone number to increment the attempts for.
     */
    private function incrementOtpAttempts(string $phone): int
    {
        $cacheKey = self::OTP_CACHE_PREFIX . ':' . md5($phone);
        $attempts = Cache::get($cacheKey, 0);
        $attempts++;
        Cache::put($cacheKey, $attempts, now()->addDay());
        return $attempts;
    }

    /**
     * Resets the number of OTP attempts for the specified phone number.
     *
     * @param string $phone The phone number to reset the attempts for.
     */
    private function resetOtpAttempts(string $phone): void
    {
        $cacheKey = self::OTP_CACHE_PREFIX . ':' . md5($phone);
        Cache::forget($cacheKey);
    }

    /**
     * Expires all OTP codes for the specified phone number.
     *
     * @param string $phone The phone number to expire the OTP codes for.
     */
    private function expireOtpCodes(): void
    {
        $this->otpTokens()
            ->notExpired()
            ->notVerified()
            ->update(['expires_at' => now()]);
    }
}

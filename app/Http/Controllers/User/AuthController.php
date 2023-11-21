<?php

namespace App\Http\Controllers\User;

use App\Exceptions\OTPSendLimitReachedException;
use App\Exceptions\OTPVerifyLimitReachedException;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function phoneExistence(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|phone:IR,mobile',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => __('user.messages.phone_is_invalid'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        return response()->json([
            'exists' => !empty($user),
            'is_registered' => (bool) $user?->isRegistered(),
        ]);
    }

    public function sendCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|phone:IR,mobile',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => __('user.messages.phone_is_invalid'),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if(!$user) {
            $user = User::create([
                'phone' => $request->phone,
            ]);
        }
        try {
            $user->sendOTPCode();
            return response()->json([
                'message' => __('auth.messages.otp_sent'),
            ]);
        } catch(OTPSendLimitReachedException $e) {
            return response()->json([
                'message' => __('auth.messages.otp_send_limit_reached'),
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('auth.messages.otp_not_sent'),
                'errors' => [
                    'exception' => $e->getMessage(),
                ],
            ], 500);
        }
    }

    public function verifyCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|phone:IR,mobile',
            'otp' => 'required|digits:6',
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = User::wherePhone($request->phone)->first();

        if(!$user) {
            return response()->json([
                'message' => __('auth.messages.user_not_found'),
            ], 404);
        }

        try {
            $verify = $user->verifyOTPCode($request->otp, $request->phone);
            if(!$verify) {
                return response()->json([
                    'message' => __('auth.messages.otp_is_invalid'),
                ], 400);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $user->update([
                'phone_verified_at' => now(),
            ]);
            return response()->json([
                'message' => __('auth.messages.successfully_logged_in'),
                'token' => $token,
            ]);
        } catch (OTPVerifyLimitReachedException) {
            return response()->json([
                'message' => __('auth.messages.otp_verify_limit_reached'),
            ], 400);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => __('auth.messages.otp_verification_failed'),
            ], 400);
        }
    }

    public function user()
    {
        $user = auth()->user();
        return response()->json(new UserResource($user));
    }
}

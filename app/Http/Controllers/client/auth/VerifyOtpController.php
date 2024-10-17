<?php

namespace App\Http\Controllers\client\auth;

use App\Http\Controllers\Controller;
use App\Helpers\CreateTokenHelper;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\client\auth\ClientLoginResource;
class VerifyOtpController extends Controller
{
    public function verifyOtp(Request $request)
    {
        $phoneNumber = $request->input('phone_number');
        $otpFromRequest = $request->input('code');

        $user = User::where('phone_number', $phoneNumber)->first();

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        if ($otpFromRequest !== $user->otpCode) {
            return $this->errorResponse('Invalid OTP', 400);
        }

        $user->otpCode = null;

        $user->save();

        $token = CreateTokenHelper::createTokenClient($user);

        return $this->successResponse($token, $user);
    }

    private function successResponse($token, $user )
    {
        return response()->json([
            'status' => 200,
            'message' => 'OTP verified successfully',
            'token' => $token,
            'user' => new ClientLoginResource($user),
        ], 200);
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }
}

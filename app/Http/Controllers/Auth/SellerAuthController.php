<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\SellerLoginRequest;
use App\Models\Seller;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerAuthController extends ApiController
{
    public function login(SellerLoginRequest $request): JsonResponse
    {
        $credentials = $this->getCredentials($request);
        return $this->loginAttempt($credentials, $request);
    }

    private function getCredentials(Request $request): array
    {
        return $request->only(['email', 'password']);
    }

    private function loginAttempt(array $credentials, Request $request): JsonResponse
    {
        try {
            return $this->createToken($credentials);

        } catch (Exception $e) {
            return $this->respondNotFound($e->getMessage());
        }
    }

    private function createToken($credentials): JsonResponse
    {
        $user = Seller::where(['email' => $credentials['email']])->firstOrFail();

        if (!Hash::check($credentials['password'], $user->password)) {
            throw new ModelNotFoundException;
        }

        $token = $user->createToken(\request()->userAgent())->plainTextToken;

        return $this->respondWithToken($token, $user);
    }

    protected function respondWithToken(string $token, Seller $user): JsonResponse
    {
        $data = [
            'access_token' => $token,
            'user' => $user
        ];
        return $this->respondCreated('', $data);

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Helper\ResponseHelper;
use App\Http\Controllers\ApiController;
use App\Http\Requests\InitUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends ApiController
{
    public function init(InitUserRequest $request)
    {
        $user = User::query()->where('phone', $request->phone)->first();
        if (!$user) {
            $user = User::create($request->all());
        }
        $token = JWTAuth::fromUser($user);
        return ResponseHelper::success('ok', $this->respondWithToken($token));
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

}
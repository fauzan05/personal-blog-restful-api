<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\UserGuestRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $inputs = $request->validated();
        $response = User::create([
            'first_name' => $inputs['first_name'],
            'last_name' => $inputs['last_name'],
            'username' => $inputs['username'],
            'email' => $inputs['email'],
            'password' => Hash::make($inputs['password']),
            'place_of_birth' => $inputs['place_of_birth'],
            'date_of_birth' => $inputs['date_of_birth'],
            'phone_number' => $inputs['phone_number'],
            'role' => UserRoleEnum::ADMIN,
        ]);

        return response()->json(
            [
                'status' => 'success',
                'code' => 201,
                'message' => 'The user has been successfully created',
                'api_version' => 'v1',
                'data' => $response,
                'error' => null,
            ],
        )->setStatusCode(201);
    }

    public function registerGuest(UserGuestRegisterRequest $request)
    {
        $inputs = $request->validated();
        $guest = User::where('username', $inputs['username'])->first();
        if(isset($guest) && $guest->email == $inputs['email'])
        {
            return response()->json(
                [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'The guest user has been already created',
                    'api_version' => 'v1',
                    'data' => $guest,
                    'error' => null,
                ],
            )->setStatusCode(200);
        }
        $guest = User::create([
            'username' => $inputs['username'],
            'email' => $inputs['email'],
            'role' => UserRoleEnum::GUEST
        ]);
        return response()->json(
            [
                'status' => 'success',
                'code' => 201,
                'message' => 'The guest user has been successfully created',
                'api_version' => 'v1',
                'data' => $guest,
                'error' => null,
            ],
        )->setStatusCode(201);
    }

    public function login(UserLoginRequest $request)
    {
        $inputs = $request->validated();
        $response = User::where('username', trim($inputs['username']))->first();
        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => 'The user has been successfully logged in',
                'api_version' => 'v1',
                'data' => $response, 'token' => $response->createToken('client-auth-token')->accessToken,
                'error' => null,
            ],
        );
    }

    public function get()
    {
        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => 'The information of current user',
                'api_version' => 'v1',
                'data' => Auth::user(),
                'error' => null,
            ],
        );

    }

    public function update(UserUpdateRequest $request)
    {
        $inputs = $request->validated();
        $response = User::find(auth()->user()->id);
        $response->fill($inputs);
        $response->save();
        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => 'The user has been successfully updated',
                'api_version' => 'v1',
                'data' => $response,
                'error' => null,
            ],
        );
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
                'code' => 200,
                'message' => 'The user has been successfully logged out',
                'api_version' => 'v1',
                'data' => null,
                'error' => null,
        ], 200);
    }

    public function destroy(Request $request)
    {
        $request->user()->delete();
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
                'code' => 200,
                'message' => 'The user has been successfully deleted',
                'api_version' => 'v1',
                'data' => null,
                'error' => null,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Requests\GetAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function create(AddressCreateRequest $request)
    {
        $inputs = $request->validated();
        $response = Address::create([
            'user_id' => $inputs['user_id'],
            'street' => $inputs['street'],
            'village' => $inputs['village'],
            'subdistrict' => $inputs['subdistrict'],
            'city' => $inputs['city'],
            'province' => $inputs['province'],
            'country' => $inputs['country'],
            'postal_code' => $inputs['postal_code']
        ]);

        return response()->json(
            [
                'status' => 'success',
                'code' => 201,
                'message' => 'The address has been successfully created',
                'api_version' => 'v1',
                'data' => $response,
                'error' => null,
            ],
            201,
        );
    }

    public function update(int $id, AddressUpdateRequest $request)
    {
        $inputs = $request->validated();
        $response = Address::find($id);
        $response->fill($inputs);
        $response->save();
        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => 'The address has been successfully updated',
                'api_version' => 'v1',
                'data' => $response,
                'error' => null,
            ],
            200,
        );
    }

    public function get()
    {
        $response = Address::where('user_id', Auth::user()->id)->get();
        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => 'The information of address by current user',
                'api_version' => 'v1',
                'data' => $response,
                'error' => null,
            ],
        );
    }

    public function delete(int $id)
    {
        $response = Address::find($id)->delete();
        return response()->json(
            [
                'status' => 'success',
                'code' => 200,
                'message' => 'The address has been successfully deleted',
                'api_version' => 'v1',
                'data' => $response,
                'error' => null,
            ],
        );
    }
     
}

<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialMediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/guest', [AuthController::class, 'registerGuest']);
Route::post('/login', [AuthController::class, 'login'])->middleware('user.login');

Route::middleware('auth:api')->group(function () {
    // Auth
    Route::get('/info', [AuthController::class, 'get']);
    Route::patch('/update', [AuthController::class, 'update'])->middleware(['username.exist', 'email.exist', 'old.password']);
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::delete('/destroy', [AuthController::class, 'destroy'])->middleware('old.password');
    // Address
    Route::post('/address', [AddressController::class, 'create'])->middleware('user.id.exist');
    Route::patch('/address/{idAddress}', [AddressController::class, 'update'])->middleware(['user.id.exist', 'address.exist'])->where('idAddress', '[0-9]+');
    Route::get('/address', [AddressController::class, 'get'])->middleware(['user.id.exist', 'address.exist']);
    Route::delete('/address/{idAddress}', [AddressController::class, 'delete'])->middleware(['user.id.exist', 'address.exist'])->where('idAddress', '[0-9]+');
    // Social Media
    Route::post('/social-media', [SocialMediaController::class, 'create'])->middleware('user.id.exist');
    Route::patch('/social-media/{idSocialMedia}', [SocialMediaController::class, 'update'])->middleware('user.id.exist')->where('idSocialMedia', '[0-9]+');
    Route::get('/social-media', [SocialMediaController::class, 'get'])->middleware('user.id.exist');
    Route::delete('/social-media/{idSocialMedia}', [SocialMediaController::class, 'delete'])->middleware(['user.id.exist', 'social.media.is.exist'])->where('isSocialMedia', '[0-9]+');
}); 
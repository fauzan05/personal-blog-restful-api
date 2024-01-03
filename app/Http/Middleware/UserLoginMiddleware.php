<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::where('username', $request->username)->first();
        if(!$user || !Hash::check($request->password, $user->password))
        {
            throw new HttpResponseException(response([
                'status' => 'failed',
                'code' => 401,
                'message' => 'Validation Error',
                'api_version' => 'v1',
                'data' => null,
                'error' => [
                    'error_message' => 'username or password is wrong'
                ]       
            ], 401));
        }
        return $next($request);
    }
}

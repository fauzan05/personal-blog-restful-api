<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostIsExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $post = Post::find($request->idPost);
        if(!$post) {
            throw new HttpResponseException(response([
                'status' => 'failed',
                'code' => 404,
                'message' => 'Not Found',
                'api_version' => 'v1',
                'data' => null,
                'error' => [
                    'error_message' => 'The post not found'
                ]       
            ], 404));
        }
        return $next($request);
    }
}

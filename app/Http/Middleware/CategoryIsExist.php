<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryIsExist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!empty($request->name)) {
            $category = Category::where('name', 'like', '%' . $request->name . '%')->first();
            if($category) {
                throw new HttpResponseException(
                    response(
                        [
                            'status' => 'failed',
                            'code' => 409,
                            'message' => 'Conflict/Duplicate Category Name',
                            'api_version' => 'v1',
                            'data' => null,
                            'error' => [
                                'error_message' => 'The category name has already exist',
                            ],
                        ],
                        409,
                    ),
                );
            }
        }
        if(!empty($request->idCategory)) {
            $category = Category::find($request->idCategory);
            if(!$category) {
                throw new HttpResponseException(
                    response(
                        [
                            'status' => 'failed',
                            'code' => 404,
                            'message' => 'Not Found',
                            'api_version' => 'v1',
                            'data' => null,
                            'error' => [
                                'error_message' => "The category has doesn't exist",
                            ],
                        ],
                        404,
                    ),
                );
            }
        }

        if(!empty($request->update_name)) {
            $currentCategory = Category::find($request->idCategory);
            $otherCategory = Category::where('name', 'like', '%' . $request->update_name . '%')->first();
            if(!empty($otherCategory) && $otherCategory->name != $currentCategory->name) {
                throw new HttpResponseException(
                    response(
                        [
                            'status' => 'failed',
                            'code' => 409,
                            'message' => 'Conflict/Duplicate Category Name',
                            'api_version' => 'v1',
                            'data' => null,
                            'error' => [
                                'error_message' => 'The category name has already exist',
                            ],
                        ],
                        409,
                    ),
                );
            }
        }
        return $next($request);
    }
}

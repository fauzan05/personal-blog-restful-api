<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaCreateRequest;
use App\Http\Requests\MediaUpdateRequest;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function create(MediaCreateRequest $request)
    {
        $inputs = $request->validated();
        $file = $inputs['image_file']->storeAs('public/images', $inputs['image_file']->hashName());
        $path = Storage::path($file);
        $response = Media::create([
            'post_id' => $inputs['post_id'],
            'name' => $inputs['image_file']->hashName(),
            'file_path' => $path,
            'type' => $inputs['image_file']->extension()
        ]);
        return response()
        ->json([
            'status' => 'success',
            'code' => 201,
            'message' => 'The media file has been successfully uploaded',
            'api_version' => 'v1',
            'data' => $response,
            'error' => null,
        ])
        ->setStatusCode(201);
    }

    public function update(int $id, MediaUpdateRequest $request)
    {
        $inputs = $request->validated();
        $response = Media::where('post_id', $id)->get();

    }
}

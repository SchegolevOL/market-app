<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{


    public function destroy(Image $image)
    {
        ImageService::destroy($image);
        $image->delete();
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ], Response::HTTP_OK);
    }
}

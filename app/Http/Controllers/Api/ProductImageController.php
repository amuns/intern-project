<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Api\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductImageRequest;

class ProductImageController extends Controller
{

    public function storeImage(Request $request)
    {
        $productId = $request->id;
        $selectedImages = $request->images;
        // $imageDetails = [];
        foreach ($selectedImages as $img){
            $relativePath = $this->saveImage($img);
                ProductImage::create([
                    'image' => URL::to(Storage::url($relativePath)),
                    'image_mime' => $img->getClientMimeType(),
                    'image_size' => $img->getSize(),
                    'product_id' => $productId
                ]);

        }

        // ProductImage::create($imageDetails);
    }


    public function deleteImage(Request $request)
    {
        // return $request->id. " ". $request->dir;

        $productId = $request->id;
        $imageDir = $request->dir;

        $path = "/images/{$imageDir}";
        Storage::deleteDirectory($path, true);
        $path = "/public/images/{$imageDir}";
        Storage::deleteDirectory($path, true);
        ProductImage::where('product_id', $productId)->where('image', "LIKE", "%{$imageDir}%")->delete();

        return response()->noContent();
    }

    private function saveImage(UploadedFile $image)
    {
        $path = 'images/' . Str::random();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }


        if (!Storage::putFileAS('public/' . $path, $image, $image->getClientOriginalName())) {
            throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
        }

        return $path . '/' . $image->getClientOriginalName();
    }
}

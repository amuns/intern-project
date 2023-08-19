<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Api\BrandingHeader;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BrandingHeaderRequest;
use App\Http\Resources\BrandingHeaderResource;
use App\Http\Resources\BrandingHeaderListResource;

class BrandingHeaderController extends Controller
{
    public function index()
    {

        $query = BrandingHeader::all();

        return BrandingHeaderListResource::collection($query);
    }

    public function store(BrandingHeaderRequest $request)
    {   
        $data = $request->validated();

        // return dd($data);

        $logo = $data['logo'] ?? null;

        if($logo){
            $relativePath = $this->saveImage($logo);
            $data['logo'] = URL::to(Storage::url($relativePath));
        }

        $brandingHeader = BrandingHeader::create($data);

        return new BrandingHeaderResource($brandingHeader);

    }

    public function update(Request $request, $id)
    {

        $brandingHeader = BrandingHeader::findOrFail($id);
        // return $brandingHeader;
        $data = [];
        $data['company_name'] = $request->input('company_name');

        if($request->hasFile('logo')){
            $relativePath = $this->saveImage($request->file('logo'));
            $data['logo'] = URL::to(Storage::url($relativePath));

            if($brandingHeader->logo){
                $imagePath = dirname($brandingHeader->logo);
                $pathArr = explode('/', $imagePath);
                Storage::deleteDirectory('/public/images/' . stripslashes($pathArr[5]), true);
                Storage::deleteDirectory('/images/' . stripslashes($pathArr[5]), true);

            }
        }else{
            $data['logo'] = $brandingHeader->logo;
        }
        
        $brandingHeader->update($data);

        return new BrandingHeaderResource($brandingHeader); 
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

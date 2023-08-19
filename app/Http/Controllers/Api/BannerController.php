<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\BannerResource;
use App\Http\Resources\BannerListResource;

class BannerController extends Controller
{
    public function index(){
        $query = Banner::where('id', '1')->get();

        return BannerListResource::collection($query);
    }

    public function store(Request $request){
        $data['title'] = $request->title;
        $data['subtitle'] = $request->subtitle;
        $data['published'] = $request->published;

        $banner = Banner::create($data);

        return new BannerResource($banner);
    }

    public function update(Request $request, Banner $banner){
        $data['title'] = $request->title;
        $data['subtitle'] = $request->subtitle;
        $data['published'] = $request->published;

        $banner->update($data);

        return new BannerResource($banner);
    }
}

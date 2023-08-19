<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Product;
use Illuminate\Support\Str;
use App\Models\Api\Category;
use Illuminate\Http\Request;
use App\Models\Api\HomeSlider;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use App\Models\Api\ProductCategory;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\HomeSliderRequest;
use App\Http\Resources\SliderProductList;
use App\Http\Resources\HomeSliderResource;
use App\Http\Resources\HomeSliderListResource;
use App\Http\Resources\HomeSliderTitleListResource;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = HomeSlider::where('slider', 1)->get();

        return HomeSliderListResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductCount(Request $request)
    {
        $productCount = ProductCategory::where('category_id', $request->catId)->count();
        return $productCount;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data['product_id'] = $request->product_id;
        $data['slider'] = $request->slider;
        $data['trending'] = $request->trending;
        $data['featured'] = $request->featured;

        $existingImage = HomeSlider::where('product_id', $request->product_id)->pluck('image');

        if ($request->image && $request->hasFile('image')) {
            $relativePath = $this->saveImage($request->image);
            $data['image'] = URL::to(Storage::url($relativePath));

            // return $existingImage;

            if (count($existingImage) > 0 && $existingImage[0] != null) {
                $pathArr = explode("/", $existingImage[0]);
                Storage::deleteDirectory('/public/images/' . stripslashes($pathArr[5]), true);
                Storage::deleteDirectory('/images/' . stripslashes($pathArr[5]), true);
            }
        } else {
            $data['image'] = $existingImage[0];
        }

        // HomeSlider::where('product_id', $request->product_id)->delete();
        // return $request->product_id;
        $slider = DB::table('home_sliders')->where('product_id', $request->product_id)->get();
        if(count($slider)<=0){
            HomeSlider::create($data);
        }else{
            HomeSlider::where('product_id', $request->product_id)->update($data);
        }

        $slider = HomeSlider::all();

        return HomeSliderResource::collection($slider);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getFeatured()
    {
        $slider = HomeSlider::where('featured', 1)->get();
        
        return new HomeSliderResource($slider);
    }

    public function show($id){

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HomeSliderRequest $request, HomeSlider $slider)
    {
        // dd($request->all());
        $data = $request->validated();
        // return $data;
        $image = $data['image'] ?? null;
        // Check if image was given and save on local file system
        if ($image) {
            $relativePath = $this->saveImage($image);
            $data['image'] = URL::to(Storage::url($relativePath));
            // $data['image_mime'] = $image->getClientMimeType();
            // $data['image_size'] = $image->getSize();

            // If there is an old image, delete it
            if ($slider->image) {
                Storage::deleteDirectory('/public/' . dirname($slider->image));
            }
        }

        $data['published'] = intval($data['published']);

        $slider->update($data);

        return new HomeSliderResource($slider);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HomeSlider $slider)
    {
        //
        $slider->delete();

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

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Api\Testimonial;
use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Http\Resources\TestimonialListResource;
use App\Http\Resources\TestimonialResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Testimonial::query()
            ->where('fullname', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return TestimonialListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       
        // $data = $request->validated();
        $data['fullname'] = $request->fullname;
        $data['feedback'] = $request->feedback;
        $data['published'] = $request->published;

        // Check if image was given and save on local file system
        if ($request->display_picture && $request->hasFile('display_picture')) {
            $relativePath = $this->saveImage($request->display_picture);
            $data['display_picture'] = URL::to(Storage::url($relativePath));
        }

        $testimonial = Testimonial::create($data);

        return new TestimonialResource($testimonial);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Testimonial $testimonial)
    {
        return new TestimonialResource($testimonial);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  Testimonial $testimonial)
    {
        // return $testimonial->display_picture;
        $data['fullname'] = $request->fullname;
        $data['feedback'] = $request->feedback;
        $data['published'] = $request->published===true?1:0;
        // return $data;
        // Check if image was given and save on local file system
        if ($request->hasFile('display_picture')) {
            $data['display_picture'] = $request->display_picture;
            $relativePath = $this->saveImage($data['display_picture']);
            $data['display_picture'] = URL::to(Storage::url($relativePath));

            // If there is an old image, delete it
            if ($testimonial->display_picture != null) {
                $existingImage = $testimonial->display_picture;
                $pathArr = explode("/", $existingImage);
                Storage::deleteDirectory('/public/images/' . stripslashes($pathArr[5]), true);
                Storage::deleteDirectory('/images/' . stripslashes($pathArr[5]), true);

            }
        }else{
            $data['display_picture'] = $testimonial->display_picture;
        }

        // $data['published'] = intval($data['published']);

        // return $data;
        $testimonial->published = $data['published'];
        $testimonial->save();
        $testimonial->update($data);

        return new TestimonialResource($testimonial);


    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Testimonial $testimonial)
    {
        if($request->input('path') != null){
            $path = "images/".$request->input('path');
            Storage::deleteDirectory($path, true);
        }
        $testimonial->delete();
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

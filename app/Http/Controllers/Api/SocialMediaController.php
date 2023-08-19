<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Api\SocialMedia;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SocialMediaRequest;
use App\Http\Resources\SocialMediaResource;
use App\Http\Resources\SocialMediaListResource;

class SocialMediaController extends Controller
{
    public function index(){
        $query = SocialMedia::all();

        return SocialMediaListResource::collection($query);
    }

    public function store(SocialMediaRequest $request){
        $data = $request->validated();

        $socialMedia = SocialMedia::create($data);

        return new SocialMediaResource($socialMedia);
    }

    public function update(SocialMediaRequest $request, $id){
        $data = $request->validated();
        SocialMedia::where('id', $id)->update($data);
        $socialMedia = SocialMedia::where('id', $id)->get();
        return SocialMediaResource::collection($socialMedia);
    }

    public function destroy($id){
        DB::table('social_medias')->where('id', $id)->delete();

        return response()->noContent();
    }
}

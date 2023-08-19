<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestimonialListResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Testimonial::take(6)->get();

        return TestimonialListResource::collection($query);
    }

}

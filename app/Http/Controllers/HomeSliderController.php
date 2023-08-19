<?php

namespace App\Http\Controllers;

use App\Models\HomeSlider;
use Illuminate\Http\Request;

class HomeSliderController extends Controller
{
    //
    public function index()
    {
        $sliders = HomeSlider::query()
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')->take(5)->get();
            // ->paginate(5);
            return view('sliders.index', [
            'sliders' => $sliders
        ]);
    }

    public function view(HomeSlider $slider){
        return view('sliders.view', ['slider' => $slider]);
    }
}

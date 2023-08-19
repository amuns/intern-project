<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\HomeSlider;
use App\Models\Testimonial;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $banner = Banner::where('published', 1)->first();

        $products = Product::query()
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')->get();
            

        
        $categories = Category::all();

        $menuItems = Page::query()->take(5)->get();

        $testimonials = Testimonial::all();


        return view('home.index', compact('products', 'banner', 'categories', 'menuItems', 'testimonials'));
    }
}

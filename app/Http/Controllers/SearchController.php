<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function searchProduct(Request $request){
        $query = $request->input("search");
        $products = Product::where('title', 'like', "%$query%")->paginate(8);
        $productImage = [];
        $i = 0;
        foreach($products as $product){
            $productImage[$i]['image'] = ProductImage::where('product_id', $product->id)->pluck('image')->first();
            $productImage[$i]['product_id'] = $product->id;
            $i++;
        }
        return view('product.index', compact('products', 'productImage'));
    }
}

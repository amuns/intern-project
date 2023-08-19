<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(8);

        return $products;
    }

    /* public function getProducts()
    {
        $products = Product::query()
            ->where('published', '=', 1)
            ->orderBy('updated_at', 'desc')
            ->take(8)
            ->get();

        return $products;
    } */

    public function getCategoryProducts($catId){
        // return $catId;
        $productIds = ProductCategory::where('category_id', $catId)->pluck('product_id');
        $catTitle = Category::where('id', $catId)->value('title');
        $products = [];
        if(count($productIds) === 1 ){

        }
        else{
            foreach($productIds as $pid){
                $data = Product::where('id', $pid)->paginate(8);
                array_push($products, $data[0]);
            }
        }

        return view('product.category', compact('products', 'catTitle'));
    }

    public function view(Product $product)
    {
        $catIds = ProductCategory::where('product_id', $product->id)->pluck('category_id')->toArray();
        $categories = [];
        $i = 0;
        $productImage = ProductImage::where('product_id', $product->id)->pluck('image')->toArray();
        foreach ($catIds as $id) {
            $categories[$i] = Category::where('id', $id)->pluck('title')->toArray();
            $i++;
        }
        
        // dd($productImage);
        return view('product.view', compact(
            'product',
            'productImage',
            'categories',
        ));
    }
}

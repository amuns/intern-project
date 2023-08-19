<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Api\Product;
use App\Models\Api\ProductCategory;
use App\Models\Api\ProductImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductController extends Controller
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

        $query = Product::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return ProductListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {   
        $data = $request->validated();
        
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;


        /** @var \Illuminate\Http\UploadedFile $image */
        $images = $request['images'] ?? null;
        // Check if image was given and save on local file system
        $imageDetails = [];
        if ($images) {
            foreach ($images as $image) {
                $relativePath = $this->saveImage($image);
                array_push($imageDetails, [
                    'image' => URL::to(Storage::url($relativePath)),
                    'image_mime' => $image->getClientMimeType(),
                    'image_size' => $image->getSize()
                ]);
            }
        }

        try {
            DB::beginTransaction();
            // return $data;
            $product = Product::create($data);

            if ($product) {

                foreach ($imageDetails as $image) {
                    ProductImage::create([
                        'image' => $image['image'],
                        'image_mime' => $image['image_mime'],
                        'image_size' => $image['image_size'],
                        'product_id' => intval($product->id)
                    ]);
                }
            }
            if (is_array($request->categories)) {
                foreach ($request->categories as $key => $cat) {
                    # code...
                    ProductCategory::create([
                        'product_id' => $product->id,
                        'category_id' => intval($cat)
                    ]);
                }
            } else {
                $categories = explode(",", $request->categories);
                foreach ($categories as $key => $cat) {
                    # code...
                    ProductCategory::create([
                        'product_id' => $product->id,
                        'category_id' => intval($cat)
                    ]);
                }
            }
            DB::commit();
            return new ProductResource($product);
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // $product = new ProductResource($product);
        // $category = Category::where($product->category_id, '=', 'id');
        // dd($category);
        return new ProductResource($product);
        // return [$product, $category];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product      $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        // return print_r($request->addImages);
        $data = $request->validated();
        // return print_r($data);
        $data['updated_by'] = $request->user()->id;

        // return dd($request->all());
        /** @var \Illuminate\Http\UploadedFile $image */
        $addImages = $request['addImages'] ?? null;
        // return print_r(dirname($images[0]['image']));
        // Check if image was given and save on local file system
        $imageDetails = [];
        if (is_array($addImages)) {
            foreach ($addImages as $img) {

                $relativePath = $this->saveImage($img);
                array_push($imageDetails, [
                    'image' => URL::to(Storage::url($relativePath)),
                    'image_mime' => $img->getClientMimeType(),
                    'image_size' => $img->getSize()
                ]);
            }
        }
        // return print_r($imageDetails);

        try {
            DB::beginTransaction();

            $product->update($data);
            ProductCategory::where('product_id', $product->id)->delete();

            if (is_array($request->categories)) {
                foreach ($request->categories as $key => $cat) {
                    # code...
                    ProductCategory::create([
                        'product_id' => $product->id,
                        'category_id' => intval($cat)
                    ]);
                }
            } else {
                $categories = explode(",", $request->categories);
                foreach ($categories as $key => $cat) {
                    # code...
                    ProductCategory::create([
                        'product_id' => $product->id,
                        'category_id' => intval($cat)
                    ]);
                }
            }

            if ($request->addImages) {
                foreach ($imageDetails as $image) {
                    ProductImage::create([
                        'image' => $image['image'],
                        'image_mime' => $image['image_mime'],
                        'image_size' => $image['image_size'],
                        'product_id' => intval($product->id)
                    ]);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return new ProductResource($product);
        }
        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        ProductCategory::where('product_id', $product->id)->delete();
        $product->delete();

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

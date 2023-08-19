<?php
/** @var \Illuminate\Database\Eloquent\Collection $products */
?>

<x-app-layout>
    @include('layouts.header')

    
    {{ Breadcrumbs::render('products') }}
    <div class="product-wrapper">

        <p class="text-center p-5">
            <span class="text-black text-3xl">Our </span> <span class="ptitle text-3xl font-semibold">Products</span>
        </p>

        <?php if (count($products) === 0): ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
        <?php else: ?>
        <div class="pagination-width">
            {{ $products->links() }}
        </div>

        <div
            class="product-list relative grid">
            @foreach ($products as $product)
                {{-- @dd($product) --}}
                <!-- Product Item -->
                <div x-data="productItem({{ json_encode([
                    'id' => $product->id,
                    'slug' => $product->slug,
                    // 'image' => $product->image,
                    'title' => $product->title,
                    'price' => $product->price,
                    'addToCartUrl' => route('cart.add', $product),
                ]) }})"
                    class="product-item overflow-hidden relative">
                    
                    <img src="{{ $product->images->image }}" alt="No img" class="product-image" />
                    

                    <div class="product-listings p-4">
                        <h3 class="product-title">
                            <a href="{{ route('product.view', $product->slug) }}">
                                {{ $product->title }}
                            </a>
                        </h3>
                        <h5 class="product-category">Category</h5>
                        <h5 class="product-price">Rs. {{ $product->price }}/-</h5>
                    </div>

                    <div class="hover-content">
                        <button class="cart-button font-semibold hover:transform hover:scale-105" @click="addToCart()">
                            Add to Cart
                        </button>

                        <ul class="grid grid-cols-1 list-none mt-3 justify-center">
                            <a href="{{ route('product.view', $product->slug) }}" class="block overflow-hidden">
                                <li class="hover:transform hover:scale-105">
                                    <span class="hover-svg">{{ Logo::infoIcon() }}</span> View details
                                </li>
                            </a>

                        </ul>
                    </div>
                </div>
                <!--/ Product Item -->
            @endforeach
        </div>
        <div class="pagination-width">
            {{ $products->links() }}
        </div>

        {{-- <div class="show-box">
        <a href="">
            Show More
        </a>
    </div> --}}

    </div>

    <?php endif; ?>

</x-app-layout>

@include('layouts.footer')

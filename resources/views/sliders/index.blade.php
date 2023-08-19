<?php
/** @var \Illuminate\Database\Eloquent\Collection $sliders */
?>

{{-- @include('helpers.logo') --}}

<div class="sliders-container relative">
    <div class="sliders-wrapper overflow-hidden">
        @if ($banner)
            {{-- {{$banner}} --}}
            <div class="slider-desc flex flex-col gap-10">
                <div class="stitle font-bold">{{ $banner['title'] }}</div>
                <div class="sdesc">
                    {{ $banner['subtitle'] }}</div>

                <a href="{{ route('products') }}">
                    <div class="primary-button text-center font-semibold">
                        Shop Now
                    </div>
                </a>
            </div>
        @endif



        <div class="swiper-wrapper">
            @foreach ($products as $product)
            {{-- {{$product->slider}} --}}
                @if($product->slider)
                <div class="swiper-slide">
                    <img class="slider-image" src="{{ $product->slider->image }}" alt="">
                    <div class="product-details relative flex flex-col">
                        <div class="product-title mb-5">{{ $product->title }}</div>
                        {{-- <div class="product-subtitle">Product Subtitle</div> --}}
                        <div class="product-price">Rs. {{ $product->price }}</div>
                        <button class="prightArr">
                            <a href="{{ route("product.view", $product->slug) }}">
                                {{ Logo::rightArrIcon() }}
                            </a>
                        </button>
                    </div>
                </div>
                @endif
            @endforeach

        </div>

        
        <div class="swiper-pagination">
        </div>
    </div>

</div>

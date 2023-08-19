@section('header')
    @include('layouts.header')
@stop
<x-app-layout>

    @include('sliders.index')


    <div class="banner-wrapper relative grid grid-cols-4">
        <div class="banner-section flex">
            <div class="banner-logo">{{ Logo::clubIcon() }}</div>
            <div class="banner-title">High Quality</div>
            <div class="banner-subtitle">crafted from top materials</div>
        </div>
        <div class="banner-section ng-margin flex">
            <div class="banner-logo">{{ Logo::tickIcon() }}</div>
            <div class="banner-title">Warranty Protection</div>
            <div class="banner-subtitle">Over 2 years</div>
        </div>
        <div class="banner-section ng-margin flex">
            <div class="banner-logo">{{ Logo::freeShippingIcon() }}</div>
            <div class="banner-title">Free Shipping</div>
            <div class="banner-subtitle ng-subtitle">*Terms and conditions apply*</div>
        </div>
        <div class="banner-section flex">
            <div class="banner-logo">{{ Logo::csrIcon() }}</div>
            <div class="banner-title">24/7 Support</div>
            <div class="banner-subtitle">Dedicated support</div>
        </div>

    </div>

    <div class="product-wrapper">
        <p class="text-center p-5">
            <span class="text-black text-3xl">Our </span> <span class="ptitle text-3xl font-semibold">Products</span>
        </p>

        <?php if (count($products) === 0): ?>
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
        <?php else: ?>
        <div class="product-list relative grid gap-8">
            @php $i=0; @endphp
            @foreach ($products as $product)
                @php $i++ @endphp
                @if ($i <= 8)
                    <div x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product),
                    ]) }})" class="product-item overflow-hidden relative">
                        <img src="{{ $product->images->image }}" alt="No img" class="product-image" />

                        <div class="product-listings p-4">
                            <h3 class="product-title">
                                <a href="{{ route('product.view', $product->slug) }}">
                                    {{ $product->title }}
                                </a>
                            </h3><br>
                            <h5 class="product-price">Rs. {{ $product->price }}/-</h5>
                        </div>

                        <div class="hover-content">
                            <button class="cart-button font-semibold hover:transform hover:scale-105"
                                @click="addToCart()">
                                Add to Cart
                            </button>

                            <ul class="grid grid-cols-1 list-none mt-3 justify-center">
                                <a href="{{ route('product.view', $product->slug) }}" class="block overflow-hidden">
                                    <li class="hover:transform hover:scale-105">
                                        <span class="hover-svg">{{ Logo::infoIcon() }}</span> View Details
                                    </li>
                                </a>

                            </ul>

                        </div>
                    </div>
                @else
                @break
            @endif
        @endforeach
    </div>
    <?php endif ?>


    <a href="/products">
        <div class="show-box">
            Show More
        </div>
    </a>
</div>


<div class="trending-container relative">
    <div class="trending-wrapper relative flex">
        <div class="trending-header flex-flow-row">
            <div class="title">Trending Products that we offer</div>
            <div class="subtitle">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for
                those interested. Sections </div>
            <a href="{{ route('products') }}" class="primary-button mt-5">Explore More</a>
        </div>
        <div class="trending-products-wrapper">
            <div class="swiper-wrapper">
                @foreach ($products as $product)
                    @if ($product->trending)
                        <div class="swiper-slide">
                            <img class="trending-image" class src="{{ $product->trending->image }}">
                            <div class="trending-product-description">
                                <div class="trending-product-title">{{ $product->title }}</div>
                                <div class="flex flex-flow-col gap-3 justify-between">
                                    <div class="trending-hr"><hr class="border-hr"></div>
                                    <div class="trending-product-price">Rs. {{ $product->price }}</div>
                                </div>
                            </div>
                            <a href="{{ route('product.view', $product->slug) }}" class="right-Arr">
                                {{ Logo::rightArrIcon() }}
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="trending-pagination-block">
                <div class="swiper-pagination"></div>
            </div>

            <div class="swiper-button-next trending-next-button"></div>

        </div>
    </div>
</div>



<div class="category-wrapper" id="categories">

    <div class="category-swiper">
        <p class="category-title">
            <span class="ptitle">Categories </span> To
            choose
            from
        </p>

        <div class="swiper-wrapper">
            @foreach ($categories as $category)
                <div class="swiper-slide cat-list flex">
                    <a href="/categories/{{ $category['id'] }}">
                        <img src="{{ $category['image'] }}" class="category-image">
                        <p class="cat-title">{{ $category['title'] }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="testimonials-container">
    <div class="ornament flex flex-flow-row">
        <img class="ornament63" src="{{ asset('./img/ornament63.png') }}" alt="">
        <img class="ornament65" src="{{ asset('./img/ornament65.png') }}" alt="">
    </div>

    <div class="testimonial-wrapper">
        <div class="testimonial-title">
            What our <span class="ptitle">Clients</span> say
        </div>

        <div class="swiper-wrapper relative row-span-3 ">

            @if (count($testimonials) <= 0)
                <div class="swiper-slide row-span-3">
                    <div class="testimonial-section p-20">
                        No Testimonials found!
                    </div>
                </div>
            @else
                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide row-span-3">
                        <div class="testimonial-section grid grid-flow-col">
                            <div class="dp relative">
                                @if ($testimonial['display_picture'] == null)
                                    <img src="{{ asset('./img/defUser.jpeg') }}" alt="">
                                @else
                                    <img src="{{ $testimonial['display_picture'] }}" alt="">
                                @endif
                            </div>

                            <div class="testimonial">
                                <div class="fullname">{{ ucwords($testimonial['fullname']) }}</div>
                                <div class="row-span-2 feedback text-justify">
                                    {{ ucfirst($testimonial['feedback']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif


        </div>

        <div class="pagination-buttons">
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>


        <div class="swiper-pagination"></div>

    </div>
</div>

@foreach ($products as $product)
    @if ($product->featured)
        <div class="featured-wrapper relative">
            <div class="featured-product relative">
                {{-- @if (array_key_exists(0, $featured)) --}}

                <img class="featured-image" src="{{ $product->featured->image }}" alt="">
                {{-- @endif --}}
                <div class="featured-desc grid grid-flow-row grid-rows-4">
                    <div>PRODUCT</div>
                    <div class="title">Featured Product</div>
                    <div class="desc">Top product of the week</div>
                    <div class="explore-link">
                        <a href="{{ route('product.view', $product->slug) }}">
                            Explore Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

</x-app-layout>

@include('layouts.footer')

<x-app-layout>
    @include('layouts.header')
    {{ Breadcrumbs::render('cart') }}
    <div class="cart-wrapper relative">
        <h1 class="cart-title mb-5 mt-5"> Your <span class="ptitle">Cart</span> Items</h1>

        <div x-data="{
        
            cartItems: {{ json_encode(
                $products->map(
                    fn($product) => [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'title' => $product->title,
                        'price' => $product->price,
                        'image' => $product->image[0] ?? null,
                        'quantity' => $cartItems[$product->id]['quantity'],
                        'href' => route('product.view', $product->slug),
                        'removeUrl' => route('cart.remove', $product),
                        'updateQuantityUrl' => route('cart.update-quantity', $product),
                    ],
                ),
            ) }},
        
        
            deliveryCharge: {{ json_encode($deliveryCharge[0]) }},
        
            get cartSubTotal() {
                return this.cartItems.reduce((accum, next) => accum + next.price * Math.abs(next.quantity), 0).toFixed(2)
            },
        
            get cartTotal() {
                {{-- return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity + {{ $deliveryCharge }}, 0).toFixed(2) --}}
                var total = Number(this.cartSubTotal) + {{ $deliveryCharge[0] }}
                return total.toFixed(2)
            },
        
        
        }" class=" relative">


            <template x-if="cartItems.length">

                <div class="vl cart-details relative">
                    <table class="cart-items">
                        <tr class="border-t border-b">
                            <th></th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>SubTotal</th>
                        </tr>
                        {{-- </table> --}}
                        <template x-for="product of cartItems" :key="product.id">
                            <tr x-data="productItem(product)" class="border-b">
                                <div class="cart-list">
                                    {{-- <tr> --}}
                                    <td>
                                        <div class="cart-image relative">
                                            <a href="#" @click.prevent="removeItemFromCart()"
                                                class="ptitle">{{ Logo::closeIcon() }}</a>
                                            <img x-bind:src="product.image" width="200px" alt="No Image">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="margin-left">
                                            <h3 x-text="product.title"></h3>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="margin-left">
                                            <span>
                                                Rs. <span x-text="product.price"></span>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="margin-left qty">
                                            Qty:
                                            <input type="number" id="product-qty" min="1"
                                                x-model="product.quantity" @change="changeQuantity()"
                                                class="ml-3 py-1 rounded border-gray-200 focus:border-orange-400 focus:ring-orange-400 w-16" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="margin-left price">
                                            <span x-text="product.price * Math.abs(product.quantity)"></span>
                                        </div>
                                    </td>
                                    {{-- </tr> --}}
                                </div>
                            </tr>
                        </template>
                    </table>

                    <div class="checkout-card">
                        <h1><span class="ptitle">Cart</span> Totals</h1>

                        <div x-model="open" x-data="{ open: false }" class="checkout-details">
                            <form action="{{ route('cart.checkout') }}" method="post">
                                @csrf
                                <div class="checkout-subtotal flex flex-flow-col justify-between">
                                    <span class="title">Subtotal</span>
                                    <span id="cartTotal" x-text="`Rs. ${cartSubTotal}`"></span>
                                </div>

                                <div class="checkout-payment-options flex flex-flow-col justify-between">
                                    <div>
                                        <span class="title">
                                            Payment Options
                                        </span>
                                    </div>



                                    <div class="">
                                        <span>
                                            <input @click="open=true" type="radio" name="cod" value="cod">
                                            Cash on delivery</span>
                                        <div x-show="open" class="">
                                            <span class="text-gray-400 w-34" id="codHeading">Delivery Charge</span><br>
                                            <span id="codAmount" class="w-24 pt-3">Rs. {{ $deliveryCharge[0] }}</span>
                                            <input type="hidden" name="deliveryCharge"
                                                value="{{ $deliveryCharge[0] }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="checkout-total flex flex-flow-col justify-between">
                                    <span class="title">Total</span>
                                    {{-- <span v-if="cartSubTotal > finalSum" x-text=""></span> --}}
                                    <template x-if="open == 'cod' || open == true" id="codAmount" class="text-xl">
                                        <span class="amt"
                                            x-text="Number(parseInt(cartSubTotal) + parseInt(deliveryCharge)).toFixed(2)"></span>
                                    </template>
                                    <template x-if="open == false">
                                        <span x-text="`Rs. ${cartSubTotal}`"></span>
                                    </template>
                                    {{-- <span id="codAmount" class="text-xl" x-text="`Rs. ${total}`"></span> --}}
                                </div>
                                <br>
                                <button type="submit" class="primary-button checkout-button">
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </template>

            <template x-if="!cartItems.length">
                <div class="empty-cart">
    
                    You don't have any items in cart!
                    <br>
                    <a href="{{ route('products') }}">
                        <button class="primary-button w-44">
                            Shop Now
                        </button>
                    </a>
                </div>
            </template>
        </div>
    </div>
</x-app-layout>
@include('layouts.footer')

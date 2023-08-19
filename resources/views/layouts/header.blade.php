@if (is_array($headerScript))
    <script>
        {{ $headerScript[0]->scripts }}
    </script>
@endif

<div class="header flex flex-flow-row gap-5" x-data="{
    mobileMenuOpen: false,
    cartItemsCount: {{ \App\Helpers\Cart::getCartItemsCount() }},
}"
    @cart-change.window="cartItemsCount = $event.detail.count">
    <div class="logo flex-none">
        <a href="/">
            @if ($brandingHeader)
                @if ($brandingHeader->logo !== null)
                    <img src="{{ $brandingHeader->logo }}">
                @else
                    <marquee>{{ $brandingHeader->company_name }}</marquee>
                @endif
            @endif
        </a>
    </div>

    <div class="section-one">
        <ul class="flex flex-row">
            <li class="dropdown">
                <div class="flex flex-flow-col">
                    <div>Category</div>
                    <div>{{ Logo::dropdownIcon() }}</div>
                </div>
                <ul class="dropdown-content">

                    @foreach ($categories as $cat)
                        <li><a href="/categories/{{ $cat->id }}">{{ $cat->title }}</a></li>
                    @endforeach
                </ul>
            </li>

            @if (count($menuItems) > 0)
                @foreach ($menuItems as $menuWithSubMenu)
                    <li class="dropdown">
                        <div class="flex flex-flow-col">
                            <div>{{ ucwords($menuWithSubMenu['title']) }}</div>

                            @if (count($menuWithSubMenu['pages']) > 0)
                                <div>{{ Logo::dropDownIcon() }}</div>
                        </div>
                        <ul class="dropdown-content list-none">
                            @if (count($menuWithSubMenu['pages']) > 1)
                                @foreach ($menuWithSubMenu['pages'] as $page)
                                    <li>
                                        <a
                                            href="{{ route('page.view', $page['slug']) }}">{{ ucfirst($page['title']) }}</a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <a href="{{ route('page.view'), $menuWithSubMenu['pages'][0]['slug'] }}">{{ $menuWithSubMenu['pages'][0]['title'] }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                @endif
                </li>
            @endforeach
            @endif

            @foreach ($pages as $page)
                <li class="page">
                    <a href="{{ route('page.view', $page->slug) }}">
                        {{ $page->title }}
                    </a>
                </li>
            @endforeach



        </ul>
    </div>

    <div class="section-two">
        <form action="{{ route('search.product') }}">
            @csrf
            <label class="search" for="search-bar"></label>
            <span class="search-svg">
                {{ Logo::searchIcon() }}
            </span>

            <input class="search-bar" name="search" type="text" placeholder="Search for products">
        </form>
    </div>

    <div class="section-three" :class="mobileMenuOpen ? 'left-0' : '-left-[220px]'">
        <ul class="list-none flex flex-row-reverse">
            @if (!Auth::guest())
                <li class="dropdown profile">
                    <img class="userImg" src="{{ asset('./img/defUser.jpeg') }}" alt="">
                    <ul class="dropdown-content rounded">
                        <li>
                            <a href="{{ route('profile') }}">
                                Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('order.index') }}">
                                Orders
                            </a>
                        </li>
                        <hr>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li>
                    <a href="{{ route('register') }}">
                        Register
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}">
                        Login
                    </a>
                </li>
            @endif
            <li class="svg-cart relative">
                <a href="{{ route('cart.index') }}">
                    {{ Logo::cartIcon() }}
                    <small x-show="cartItemsCount" x-transition x-text="cartItemsCount" x-cloak class="count"></small>
                </a>

            </li>
        </ul>

    </div>

</div>

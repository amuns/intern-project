<div class="footer-wrapper relative">
    <img class="frame" src="{{ asset('./img/footerFrame.png') }}" alt="">
    <div class="footer flex flex-flow-col">
        <div class="footer-main grid grid-flow-row grid-rows-4 gap-10">
            <div class="logo">
                @if ($brandingHeader->logo)
                    <img src="{{ $brandingHeader->logo }}">
                @else
                    {{ $brandingHeader->company_name }}
                @endif
            </div>
            <div class="icons row-span-2">
                @foreach ($socialMedias as $handle)

                    @switch($handle->title)
                        @case("facebook")
                            <a href="{{ $handle->link }}"><img src="{{ asset('./img/facebook.png') }}"></a>
                        @break

                        @case("instagram")
                            <a href="{{ $handle->link }}"><img src="{{ asset('./img/instagram.png') }}"></a>
                        @break

                        @case("twitter")
                            <a href="{{ $handle->link }}"><img src="{{ asset('./img/twitter.png') }}"></a>
                        @break

                        @case("linkedIn")
                            <a href="{{ $handle->link }}"><img src="{{ asset('./img/linkedIn.png') }}"></a>
                        @break
                    @endswitch
                    
                @endforeach
            </div>
            <div class="copyright">
                &#169; 2023 DataOver. All rights reserved.
            </div>
        </div>

        <div class="section">
            <div class="heading">Products</div>

            @foreach($categories as $cat)
                <div class="sub-heading"><a href="/categories/{{$cat->id}}">{{$cat->title}}</a></div>
            @endforeach
        </div>
        

        @foreach ($menuItems as $menu)
            <div class="section">
                <div class="heading">{{ ucwords($menu['title']) }}</div>
                @if (count($menu['pages']) > 1)
                    @foreach ($menu['pages'] as $page)
                        <div class="sub-heading"><a href="{{ route('page.view', $page['slug']) }}">{{ ucfirst($page['title']) }}</a></div>
                    @endforeach
                @else
                    <div><a
                            href="{{ route('page.view', $menu['pages'][0]['slug']) }}">{{ ucfirst($menu['pages'][0]['title']) }}</a>
                    </div>
                @endif
            </div>
        @endforeach

    </div>
</div>

@if(is_array($footerScript))
<script>
    {{ $footerScript[0]->scripts }}
</script>
@endif
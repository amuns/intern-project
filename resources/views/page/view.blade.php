@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)
@section('keywords', $page->keywords)

<x-app-layout>
    @include('layouts.header')
    {{ Breadcrumbs::render('pages',$page) }}
    <div class="page-view-wrapper">
        <div class="page-title">
            {{ $page->title}}
        </div>
        <div class="page-body">
            {!! $page->body !!}
        </div>
    </div>
</x-app-layout>
@include('layouts.footer')
<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.header', function($view){
            $categories = Request::input('categories');
            $menuItems = Request::input('menuWithSubMenu');
            $pages = Request::input('pages');
            $brandingHeader = Request::input('brandingHeader');
            $headerScript = Request::input('headerScript');
            // $categories = Category::all();
            // $view->with(compact([]));
            // $view->with('categories', $categories);
            $view->with([
                'categories'=> $categories,
                'menuItems'=> $menuItems,
                'pages' => $pages,
                'brandingHeader' => $brandingHeader,
                'headerScript' => $headerScript,
            ]);
        });

        View::composer('layouts.footer', function($view){
            $categories = Request::input('categories');
            $menuItems = Request::input('menuWithSubMenu');
            $brandingHeader = Request::input('brandingHeader');
            $footerScript = Request::input('footerScript');
            $socialMedias = Request::input('socialMedias');

            $view->with([
                'categories' => $categories,
                'menuItems'=> $menuItems,
                'brandingHeader' => $brandingHeader,
                'footerScript' => $footerScript,
                'socialMedias' => $socialMedias,

            ]);
        });
    }
}

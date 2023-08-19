<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Script;
use App\Models\SubMenu;
use App\Models\Category;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\BrandingHeader;
use Illuminate\Support\Facades\DB;

class FetchHeaderAndFooterData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $categories = Category::all();

        $brandingHeader = BrandingHeader::first();

        $pages = DB::table('pages')->where('published', 1)->whereNotIn('id', DB::table('sub_menus')->select('page_id'))->get();

        $menuWithSubMenu = [];

        $menu = Menu::all();

        $headerScript = Script::select('scripts')->where("header", 1)->get();
        $footerScript = Script::select('scripts')->where("footer", 1)->get();

        $socialMedias = SocialMedia::select('title', 'link')->get();

        $i = 0;

        foreach ($menu as $menuItem) {
            $menuPages = Page::select('id', 'title', 'slug')->whereIn('id', DB::table('sub_menus')->select('page_id'))->get();
            $menuWithSubMenu[$i]['id'] = $menuItem->id;
            $menuWithSubMenu[$i]['title'] = $menuItem->title;
            $menuWithSubMenu[$i]['pages'] = $menuPages;
            $i += 1;
        }

        $request->merge(['pages' => $pages]);
        $request->merge(['categories' => $categories]);
        if($brandingHeader!==null){
            $request->merge(['brandingHeader' => $brandingHeader]);
        }
        $request->merge(['menuWithSubMenu' => $menuWithSubMenu]);
        $request->merge(['headerScript'=>$headerScript]);
        $request->merge(['footerScript'=>$footerScript]);
        $request->merge(['socialMedias'=>$socialMedias]);


        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use App\Http\Resources\MenuListResource;

class FetchMenuSubMenu
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
        $menuWithSubMenu = [];

        $menu = Menu::all();
        
        $i=0;

        foreach($menu as $menuItem){
            $subMenu = SubMenu::select('page_id')->where('menu_id', $menuItem->id)->get() ?? null;
           
            $menuWithSubMenu[$i]['id'] = $menuItem->id;
            $menuWithSubMenu[$i]['title'] = $menuItem->title;
            $menuWithSubMenu[$i]['page_id'] = $subMenu;

            $i+=1;
        }
        
        // return $menuWithSubMenu;
        $request->merge(['menuWithSubMenu' =>$menuWithSubMenu]);


        return $next($request); 
        
        
    }
}

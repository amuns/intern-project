<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuListResource;
use App\Models\Menu;
use App\Models\SubMenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMenuItems()
    {
        $query = Menu::all();
        
        return MenuListResource::collection($query);
    }

}

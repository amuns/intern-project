<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Api\Menu;
use App\Models\Api\SubMenu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Http\Resources\MenuListResource;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $query = Menu::all();

        return MenuListResource::collection($query);
    }

    public function getRecentMenu()
    {
        $query = Menu::orderBy('id', 'desc')->first();

        return MenuListResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request->validated();

        try {
            DB::beginTransaction();
            $menu = Menu::create(['title' => $request->title]);
            $pageIds = $request->pages; //array

            if (is_array($pageIds) && count($pageIds) > 0) {
                foreach ($pageIds as $page_id) {
                    SubMenu::create([
                        'menu_id' => $menu->id,
                        'page_id' => $page_id,
                    ]);
                }
            }

            DB::commit();
            return new MenuResource($menu);
        } catch (Exception $e) {
            DB::rollBack();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $data = $request->validated();
        // $data['updated_by'] = $request->user()->id;

        $menu->update($data);

        return new MenuResource($menu);
    }

    public function addSubtitle(Request $request, SubMenu $subMenu)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->noContent();
    }
}

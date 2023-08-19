<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Page;
use App\Models\SubMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuId = Menu::where('title', 'Support')->value('id');
        $pageIds = Page::select('id')->get();

        foreach($pageIds as $pid){
            SubMenu::create([
                'menu_id' => $menuId,
                'page_id' => $pid->id,
            ]);
        }
    }
}

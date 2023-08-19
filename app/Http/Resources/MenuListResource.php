<?php

namespace App\Http\Resources;

use App\Models\Page;
use App\Models\SubMenu;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $groupedPages = SubMenu::where('menu_id', $this->id)->get();
        $pages = Page::select('id', 'title')->get();
        $pageDetails = [];

        foreach($pages as $page){
            foreach($groupedPages as $groupedPage){
                if($groupedPage['page_id'] == $page['id']){
                    array_push($pageDetails, [
                        'page_id' => $page['id'],
                        'page_title' => $page['title'],
                    ]);
                }
            }
        }

        return [
            'id' => $this->id, 
            'title' => $this->title,
            'pages' => $pageDetails,
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}

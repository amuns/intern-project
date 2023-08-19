<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Page;
use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageListResource;
use App\Http\Resources\PageResource;

class PageController extends Controller
{
    public function index(){
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Page::query()
            ->where('title', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return PageListResource::collection($query);
    }

    public function show(Page $page){
        return new PageResource($page);
    }

    public function store(PageRequest $request){
        $data = $request->validated();

        // $data['body']=htmlentities($data['body']);

        $page = Page::create($data);

        return new PageResource($page);
    }

    public function update(PageRequest $request, Page $page){
        $data = $request->validated();

        $page->update($data);

        return new PageResource($page);
    }

    public function destroy(Page $page){
        $page->delete();
        
        return response()->noContent();
    }
}

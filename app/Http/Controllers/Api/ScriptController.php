<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Script;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScriptRequest;
use App\Http\Resources\ScriptResource;

class ScriptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Script::first();
        // return $query;
        if ($query == null) {
            return null;
        } else {
            return new ScriptResource($query);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['scripts'] = $request->scripts;
        $data['header'] = $request->header??0;
        $data['footer'] = $request->footer??0;
        $script = Script::create($data);

        return new ScriptResource($script);
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
    public function update(Request $request, Script $script)
    {
        $data['header'] = $request->header??0;
        $data['footer'] = $request->footer??0;

        if($request->scripts && $request->scripts != null){
            $data['scripts'] = $request->scripts;
        }

        $script->update($data);
        return new ScriptResource($script);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

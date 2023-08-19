<?php

namespace App\Http\Controllers;

use App\Models\Script;
use Illuminate\Http\Request;
use App\Http\Resources\ScriptResource;

class ScriptController extends Controller
{
    public function index(){
        $query = Script::first();
        return new ScriptResource($query);
    }
}

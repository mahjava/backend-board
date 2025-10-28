<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
class ProjectController extends Controller
{
    public function getAll(Request $request){
     
        return response()->json(Project::where('owner_id',Auth::guard('api')->user()->id)->get());
    }

    public function store(Request $request){
        
        $project = new Project();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->owner_id= Auth::guard('api')->user()->id;
        $project->save();
         return response()->json(
            [ 'success'=>true,
            'message'=>'ثبت موفقیت آمیز بود',]
        );

    }
}

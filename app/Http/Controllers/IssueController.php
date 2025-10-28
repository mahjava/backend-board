<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
    public function index(Request $request){
        $issue = Issue::where('project_id',$request->project_id)->get();
          return response()->json($issue);
    }
    public function store(Request $request){
        
        $issue = new Issue();
        $issue->title = $request->title;
        $issue->id=$request->project_id;
        $issue->save();
        return response()->json(
            [ 'success'=>true,
            'message'=>'ثبت موفقیت آمیز بود',]
        );

    }
}

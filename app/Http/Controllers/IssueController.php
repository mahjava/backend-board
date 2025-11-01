<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IssueController extends Controller
{
    public function index(Request $request)
    {

        $request->validate([

            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('owner_id', auth()->id());
                }),
            ],
        ]);

        $issue = Issue::where('project_id', $request->project_id)->get();

        return response()->json($issue);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'project_id' => [
                'required',
                Rule::exists('projects', 'id')->where(function ($query) {
                    $query->where('owner_id', auth()->id());
                }),
            ],
        ]);


        $max= Issue::where('project_id', $request->project_id)->max('number');
        $number=$max+1;

        $issue = new Issue;
        $issue->title = $request->title;
        $issue->project_id = $request->project_id;
        $issue->number=$number;
        $issue->save();

        return response()->json(
            [
                'success' => true,
                'message' => 'ثبت موفقیت آمیز بود',
            ]
        );

    }
}

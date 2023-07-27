<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function report(Request $request, Post $post)
    {
        // Validate the report data
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        // Create a new report for the post
        $report = new Report();
        $report->reason = $request->input('reason');
        $report->post()->associate($post);
        $report->user()->associate(auth()->user());
        $report->save();

        // Increment the reports_count on the post
        $post->increment('reports_count');

        // Redirect to the post page
        return redirect()->route('posts.show', $post);
    }

    //create
    public function create($id)
    {
        $post = Post::find($id);
        return view('report.create', compact('post'));
    }
}

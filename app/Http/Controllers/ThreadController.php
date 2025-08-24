<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    //
    public function store(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $forum->threads()->create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}

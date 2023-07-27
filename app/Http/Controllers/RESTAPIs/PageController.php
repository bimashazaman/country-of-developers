<?php

namespace App\Http\Controllers\RESTAPIs;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }


    public function index()
    {
        $pages = Auth::user()->pages;
        return response()->json($pages, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:pages|max:255',
            'avatar' => 'nullable|image',
            'cover' => 'nullable|image',
            'phone' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable|max:255',
        ]);

        $page = new Page;
        $page->user_id = Auth::id();
        $page->name = $validatedData['name'];
        $page->description = $validatedData['description'];
        $page->username = $validatedData['username'];
        $page->phone = $validatedData['phone'];
        $page->address = $validatedData['address'];

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName =  $avatar->getClientOriginalName();

            $avatar->move(public_path('avatars'), $fileName);
            $page->avatar = $fileName;
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = $cover->getClientOriginalName();
            $cover->move(public_path('covers'), $fileName);
            $page->cover = $fileName;
        }

        $page->save();

        return response()->json($page, 201); // 201 Created
    }

    public function show($id)
    {
        $page = Page::latest()->where('username', $id)->first();
        $pagePost = $page->posts;
        return response()->json(compact('page', 'pagePost'), 200);
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|unique:pages,username,' . $page->id,
            'avatar' => 'nullable|max:255',
            'cover' => 'nullable|max:255',
            'phone' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'description' => 'nullable|max:255',
        ]);

        // handle data updates as before...

        $page->save();

        return response()->json($page, 200); // 200 OK
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json(null, 204); // 204 No Content
    }
}

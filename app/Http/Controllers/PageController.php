<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $allPages = Page::all();
        $pages = Auth::user()->pages;
        $user = Auth::user();
        $friends = $user->friends;
        return view('pages.index', compact('pages', 'allPages', 'friends'));
    }


    //search pages
    public function search(Request $request)
    {
        $search = $request->get('search');
        $pages = Page::where('name', 'like', '%' . $search . '%')->paginate(5);
        return view('pages.index', compact('pages'));
    }



    public function create()
    {
        $pages = Auth::user()->pages;
        $user = Auth::user();
        $friends = $user->friends;
        return view('pages.create', compact('pages', 'friends'));
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

        $user = Auth::user();

        $page = new Page;
        $page->user_id = Auth::id();
        $page->name = $validatedData['name'];
        $page->description = $validatedData['description'];
        $page->username = $validatedData['username'];
        $page->phone = $validatedData['phone'];
        $page->address = $validatedData['address'];


        $uploadsPath = public_path('avatars');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $fileName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move($uploadsPath, $fileName);
            $validatedData['avatar'] = $fileName;
            if ($user->avatar) {
                Storage::delete('avatars/' . $user->avatar);
            }
        }

        $uploadsPath = public_path('covers');
        if (!file_exists($uploadsPath)) {
            mkdir($uploadsPath, 0777, true);
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $fileName = time() . '_' . $cover->getClientOriginalName();
            $cover->move($uploadsPath, $fileName);
            $validatedData['cover'] = $fileName;
            if ($user->cover) {
                Storage::delete('covers/' . $user->cover);
            }
        }


        $page->save();

        return redirect()->back()->with('success', 'Page created successfully');
    }



    public function show($id)
    {
        $page = Page::latest()->where('username', $id)->first();
        $pagePost = $page->posts;
        return view('pages.show', compact('page', 'pagePost'));
    }

    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
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

        $page->name = $request->name;
        $page->description = $request->description;
        $page->avatar = $request->avatar;
        $page->cover = $request->cover;
        $page->username = $request->username;
        $page->phone = $request->phone;
        $page->address = $request->address;
        $page->save();

        return redirect()->back()->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->back()->with('success', 'Page deleted successfully.');
    }
}

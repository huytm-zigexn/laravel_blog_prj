<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminTagValidate;
use App\Models\Tag;
use App\QueryFilters\TagFilter;

class TagController extends Controller
{
    public function index(TagFilter $filters)
    {
        $tags = Tag::filter($filters)->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(AdminTagValidate $request)
    {
        Tag::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag created successfully');
    }

    public function edit($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(AdminTagValidate $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $tag->name = $request->name;
        $tag->description = $request->description;

        $tag->save();

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully');
    }

    public function destroy($slug)
    {
        $tag = tag::where('slug', $slug);
        $tag->delete();
        return back()->with('success', 'Tag deleted successfully');
    }
}

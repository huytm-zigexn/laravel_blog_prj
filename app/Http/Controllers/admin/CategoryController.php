<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCategoryValidate;
use App\Models\Category;
use App\QueryFilters\CategoryFilter;

class CategoryController extends Controller
{
    public function index(CategoryFilter $filters)
    {
        $categories = Category::filter($filters)->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(AdminCategoryValidate $request)
    {
        Category::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('admin.categories.edit', compact('category'));
    }

    public function update(AdminCategoryValidate $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($slug)
    {
        $category = Category::where('slug', $slug);
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }
}

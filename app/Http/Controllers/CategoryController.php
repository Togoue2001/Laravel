<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        return view('instructor.categories.index', [
            'categories' => Category::orderBy('created_at', 'desc')->paginate(10)
        ]);
    }

    public function create()
    {
        $category = new Category();
        return view('instructor.categories.form', [
            'category' => $category
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return to_route('instructor.category.index')->with('success', 'la categorie a été ajouté');
    }

    public function edit(Category $category)
    {
        return view('instructor.categories.form', [
            'category' => $category
        ]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        $category->update($validated);

        return redirect()->route('instructor.category.index')->with('success', 'Catégorie mise à jour');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return to_route('instructor.category.index')->with('success', 'la categorie a été supprimer');
    }
}

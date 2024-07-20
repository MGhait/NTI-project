<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id')->paginate(5);
        return view('dashboard.categories.index', compact('categories'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Please enter category name',
            'description.required' => 'Please enter category description',
        ]);
        $category = new Category();
        $category->name = request('name');
        $category->description = request('description');
        if (request('isActive')== null) {
            $category->isActive = 0;
        }else {
            $category->isActive = 1;
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        request()->validate([
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'Please enter category name',
            'description.required' => 'Please enter category description',
        ]);
        $category->name = request('name');
        $category->description = request('description');
        if (request('isActive')== null) {
            $category->isActive = 0;
        }else {
            $category->isActive = 1;
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success','Category deleted successfully');
    }

    public function isActive(Category $category)
    {
        if($category->isActive == 0){
            $category->isActive = 1;
        }
        else{
            $category->isActive = 0;
        }

        $category->save();
        return redirect()->route('categories.index')
            ->with('success','Category status changes successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $products = Product::orderBy('id','desc')->paginate(6);
        return view('dashboard.products.index',compact('products', 'categories'))
            ->with('i', (request()->input('page', 1) - 1) * 6);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Please enter category name',
            'description.required' => 'Please enter category description',
            'price.required' => 'Please enter price',
            'category.required' => 'Please enter category name',
        ]);
        $image = $request->file('photo');
        $imageName = time().'.'.$image->getClientOriginalName();
        $request->photo = $imageName;
        $image->move(public_path('images'), $imageName);
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = request('description');
        $product->price = $request->price;
        $product->needReview = true;
        $product->added_by = Session::get('userId');
        $product->photo = $imageName;
        $product->category_id = request('category_id');
        $product->save();
        return redirect()->route('products.index')
            ->with('success','Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('dashboard.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Please enter category name',
            'description.required' => 'Please enter category description',
            'price.required' => 'Please enter price',
            'category.required' => 'Please enter category name',
        ]);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');
        $product->needReview = $request->input('needReview');
        $product->added_by = Session::get('userId');
        if ($request->photo != null) {
            unlink(public_path('images') . '/' . $product->photo);
            $image = $request->file('photo');
            $imageName = time().'.'.$image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $product->photo = $imageName;
        }
        $product->save();
        return redirect()->route('products.index')
            ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }
    public function publish(Product $product)
    {
        Product::whereIn('id', $product->id)->update(['needReview' => 0]);
        return redirect()->route('products.index')->with('success','Product published successfully');
    }
}
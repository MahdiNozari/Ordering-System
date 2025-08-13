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
        $categories= Category::all();
        return view('category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','string'],
            'status' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('category.index')->with('success','دسته بندی با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required','string'],
            'status' => 'required'
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status
        ]);
        return redirect()->route('category.index')->with('success','دسته بندی با موفقیت ویرایش  شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category -> delete();
        return redirect()->route('category.index')->with('success','دسته بندی با موفقیت حذف  شد');

    }
}

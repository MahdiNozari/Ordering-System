<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features=Feature::all();
        return view('feature.index',compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('feature.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required','string'],
            'icon' => ['required','string'],
            'body' => ['required','string']
        ]);

        Feature::create([
            'title' => $request->title,
            'body' => $request->body,
            'icon' => $request->icon,
        ]);
        
        return redirect()->route('features.index')->with('success','ویژگی با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        return view('feature.edit',compact('feature'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'title' => ['required','string'],
            'icon' => ['required','string'],
            'body' => ['required','string']
        ]);

        $feature->update([
            'title' => $request->title,
            'body' => $request->body,
            'icon' => $request->icon,
        ]);
        
        return redirect()->route('features.index')->with('success','ویژگی با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('features.index')->with('success','ویژگی با موفقیت حذف شد');

    }
}

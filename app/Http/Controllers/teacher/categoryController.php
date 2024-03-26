<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::where('user_id', Auth::id())->latest()->get();
        return view('teacher.categories.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teacher.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'user_id' => Auth::id()
        ]);

        notyf('New Category has been added', 'success');
        return redirect()->back();
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
        if($category->user_id != Auth::id()){
            notyf('Access Denied', 'error');
            return redirect()->back();
        }

        return view('teacher.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if($category->user_id != Auth::id()){
            notyf('Access Denied', 'error');
            return redirect()->back();
        }

        $request->validate([
            'name' => 'required'
        ]);

        $category->update([
            'name' => $request->name
        ]);

        notyf('Category has been updated', 'success');
        return redirect()->route('teacher.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->user_id != Auth::id()){
            notyf('Access Denied', 'error');
            return redirect()->back();
        }

        $category->delete();
        notyf('Category has been deleted', 'error');
        return redirect()->back();
    }
}

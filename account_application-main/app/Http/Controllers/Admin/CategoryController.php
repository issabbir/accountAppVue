<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = Category::all();

        return response()->json([
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:100',
            'remarks' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => slugify($request->name),
            'remarks' => $request->remarks,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        return response()->json(['category', $category], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:5|max:100',
            'remarks' => 'required'
        ]);

//        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->slug = slugify($request->name);
        $category->remarks = $request->remarks;
        if ($category->save()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category->delete()) {
            $success = true;
        }else {
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeItems(Request $request)
    {
//        return $request;exit();
        $sl = 0;
        foreach ($request->data as $id)
        {
            $category = Category::find($id);
            $category->delete();
            $sl++;
        }
        $success = $sl > 0 ? true : false;
        return response()->json(['success' => $success, 'total' => $sl], 200);
    }
}

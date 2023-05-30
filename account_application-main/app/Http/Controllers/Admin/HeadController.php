<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Head;
use Illuminate\Http\Request;

class HeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $head = Head::with('subhead', 'parentHeads')->get();
        $parentHeads = Head::whereNull('parent_id')->get();
        return response()->json(['head' => $head, 'parentHeads' => $parentHeads]);
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
            'head_name' => 'required',
        ]);

        Head::create([
            'head_name' => $request->head_name,
            'parent_id' => $request->parent_id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\Response
     */
    public function show(Head $head)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $head = Head::where('id', $id)->first();
        return response()->json(['head', $head], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'head_name' => 'required',
        ]);
        $head = Head::find($request->id);
        $head->head_name = $request->head_name;
        $head->parent_id = $request->parent_id;
        if ($head->update()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Head  $head
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $head = Head::where('id', $id)->find($id);
//        dd($head);
        $delete = $head->delete();
        if ($delete) {
            $success = true;
        }else {
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }
}

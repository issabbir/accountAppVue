<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $suppliers = Supplier::all();

        return response()->json([
            'suppliers' => $suppliers
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            's_name' => 'required|min:5|max:100',
            's_company_name' => 'required',
            's_location' => 'required',
            's_phone' => 'required|numeric',
            's_email' => 'required|email',
            's_address' => 'required',
            's_remarks' => 'required'
        ]);

        $supplier = new Supplier;
        $supplier->s_name = $request->s_name;
        $supplier->s_company_name = $request->s_company_name;
        $supplier->s_location = $request->s_location;
        $supplier->s_phone = $request->s_phone;
        $supplier->s_slug = slugify($request->s_name);
        $supplier->s_email = $request->s_email;
        $supplier->s_address = $request->s_address;
        $supplier->s_remarks = $request->s_remarks;
        if ($supplier->save()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
//        Supplier::create([
//            's_name' => $request->s_name,
//            's_contact' => $request->s_contact,
//            's_email' => $request->s_email,
//            's_address' => $request->s_address,
//            's_remarks' => $request->s_remarks,
//            'slug' => slugify($request->s_name)
//        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $supplier = Supplier::where('slug', $slug)->first();

        return response()->json(['supplier', $supplier], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, supplier $supplier)
    {
        $request->validate([
            's_name' => 'required|min:5|max:100',
            's_phone' => 'required|numeric',
            's_email' => 'required|email',
            's_address' => 'required',
            's_remarks' => 'required'
        ]);
        $supplier = Supplier::find($request->id);
        $supplier->s_name = $request->s_name;
        $supplier->s_phone = $request->s_phone;
        $supplier->slug = slugify($request->s_name);
        $supplier->s_email = $request->s_email;
        $supplier->s_address = $request->s_address;
        $supplier->s_remarks = $request->s_remarks;
        if ($supplier->update()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\supplier  $supplier
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($slug)
    {
        $supplier = Supplier::where('slug', $slug)->first();
        if ($supplier->delete()) {
            $success = true;
        }else {
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }
}

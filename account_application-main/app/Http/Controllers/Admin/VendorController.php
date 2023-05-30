<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use App\Models\Slip;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $vendors = Vendor::with('project', 'slip')->get();
        $projects = Project::all();

        return response()->json([
            'vendors' => $vendors,
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'v_name' => 'required',
            'v_phone' => 'required|numeric',
            'v_email' => 'required|email',
        ]);

        Vendor::create([
            'project_id' => $request->project_id,
            'v_name' => $request->v_name,
            'v_phone' => $request->v_phone,
            'v_email' => $request->v_email,
            'v_address' => $request->v_address,
            'v_type' => $request->v_type,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $vendor = Vendor::with('project', 'debitVoucher')->where('id', $id)->first();

        return response()->json(['vendor', $vendor], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $vendor = Vendor::with('project')->where('id', $id)->first();

        return response()->json(['vendor', $vendor], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Vendor $vendor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,Vendor $vendor)
    {
        $vendor = Vendor::find($request->id);
        $vendor->project_id = $request->project_id;
        $vendor->v_name = $request->v_name;
        $vendor->v_phone = $request->v_phone;
        $vendor->v_email = $request->v_email;
        $vendor->v_address = $request->v_address;
        $vendor->v_type = $request->v_type;
        if ($vendor->save()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return Response
     */
    public function destroy(Client $client)
    {
        //
    }
}

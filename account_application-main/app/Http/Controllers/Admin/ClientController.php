<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json([
            'clients' => $clients
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
            'c_name' => 'required',
            'c_phone' => 'required|numeric',
            'c_email' => 'required|email',
        ]);

        Client::create([
            'c_name' => $request->c_name,
            'c_phone' => $request->c_phone,
            'c_email' => $request->c_email,
            'c_address' => $request->c_address,
            'c_remarks' => $request->c_remarks,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Client $client, $id)
    {
        $head = Client::where('id', $id)->first();
        return response()->json(['head', $head], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'c_name' => 'required',
            'c_phone' => 'required|numeric',
            'c_email' => 'required|email',
            'c_address' => 'required',
            'c_remarks' => 'required',
        ]);
        $client = Client::find($request->id);
        $client->c_name = $request->c_name;
        $client->c_phone = $request->c_phone;
        $client->c_email = $request->c_email;
        $client->c_address = $request->c_address;
        $client->c_remarks = $request->c_remarks;
        if ($client->update()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $client = Client::where('id', $id)->find($id);
//        dd($client);
        $delete = $client->delete();
        if ($delete) {
            $success = true;
        }else {
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }
}

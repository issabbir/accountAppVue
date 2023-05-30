<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projects = Project::with('client')->get();
        $client = Client::all();

        return response()->json([
            'projects' => $projects,
            'client' => $client
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
            'project_name' => 'required|min:5|max:100',
            'owner_phone' => 'required|numeric'
        ]);

        Project::create([
            'client_id' => $request->client_id,
            'project_name' => $request->project_name,
            'owner_phone' => $request->owner_phone,
            'owner_image' => null,
            'project_location' => $request->project_location,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $project = Project::where('id', $id)->first();

        return response()->json(['project', $project], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $project = Project::where('id', $id)->first();

        return response()->json(['project', $project], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'project_name' => 'required',
            'owner_phone' => 'required',
            'project_location' => 'required'
        ]);
        $project = Project::find($request->id);
        $project->client_id = $request->client_id;
        $project->project_name = $request->project_name;
        $project->owner_phone = $request->owner_phone;
        $project->owner_image = $request->owner_image;
        $project->project_location = $request->project_location;
        if ($project->update()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $project = Project::where('id', $id)->find($id);
//        dd($project);
        $delete = $project->delete();
        if ($delete) {
            $success = true;
        }else {
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }
}

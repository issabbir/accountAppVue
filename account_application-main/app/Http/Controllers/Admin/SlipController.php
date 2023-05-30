<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slip;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'company_name' => 'required',
            'slip_amount' => 'required|numeric',
        ]);

        Slip::create([
            'vendor_id' => $request->vendor_id,
            'head_id' => $request->head_id,
            'childhead_id' => $request->childhead_id,
            'slip_code' => $request->slip_code,
            'company_name' => $request->company_name,
            'slip_amount' => $request->slip_amount,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slip  $slip
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $slip = Slip::with('project')->where('id', $id)->get();

        return response()->json(['slip', $slip], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function slips(Request $request, $id)
    {
        $slips = DB::select('SELECT
    sl.*,
    ven.v_name,
    he.head_name,
    (SELECT pro.project_name FROM projects pro WHERE pro.id = ven.project_id) AS project_name,
    (SELECT GROUP_CONCAT(hea.head_name SEPARATOR \', \') FROM heads hea WHERE hea.parent_id = he.id) AS child_head_name
FROM
    `slips` sl,
    `vendors` ven,
    heads he
WHERE
    sl.vendor_id = ven.id AND sl.head_id = he.id AND  sl.vendor_id = :vendor_id',['vendor_id' => $id]);
        $vendor = Slip::with('vendor', 'head', 'subhead')
                ->select('slips.*', 'vendors.project_id', 'projects.project_name')
                ->leftJoin('vendors', function ($join){
                    $join->on('slips.vendor_id', '=', 'vendors.id');
                })
                ->leftJoin('projects', 'vendors.project_id', '=', 'projects.id')
                ->where('vendor_id', $id)
                ->get();
        $vendor_id = $id;
        return response()->json(['vendor', $vendor,'slips', $slips,'vendor_id', $vendor_id], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slip  $slip
     * @return \Illuminate\Http\Response
     */
    public function edit(Slip $slip)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slip  $slip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slip $slip)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slip  $slip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slip $slip)
    {
        //
    }
}

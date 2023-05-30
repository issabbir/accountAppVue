<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\DebitVoucher;
use App\Models\Head;
use App\Models\Project;
use App\Models\Slip;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DebitVoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $vendors = Vendor::with('debitVoucher')->get();
        $deb_voucher = DebitVoucher::with('project', 'user', 'slip', 'vendor')->get();
        $d_voucher = DebitVoucher::with('project', 'user', 'slip', 'vendor')->get();
        $d_voucher = $d_voucher->keyBy('project_id');
        $d_voucher = $d_voucher->values()->all();
//        $debit = $d_voucher->shift();
        $projects = Project::with('debitVouchers')->get();
        $slips = Slip::all();
        $parentHeads = Head::whereNull('parent_id')->with('subhead')->get();
        $childHeads = Head::whereNotNull('parent_id')->with('parentHeads')->get();
        return response()->json([
            'd_voucher' => $d_voucher,
            'projects' => $projects,
            'vendors' => $vendors,
            'slips' => $slips,
            'parentHeads' => $parentHeads,
            'childHeads' => $childHeads,
//            'debit' => $debit,
            'deb_voucher' => $deb_voucher,
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
            'project_id' => 'required',
            'd_amount' => 'required',
        ]);

        DebitVoucher::create([
            'project_id' => $request->project_id,
            'vendor_id' => $request->vendor_id,
            'slip_id' => $request->slip_id,
            'slip_code' => $request->slip_code,
//            'company_name' => $request->company_name,
            'slip_amount' => $request->slip_amount,
            'd_amount' => $request->d_amount,
            'due_amount' => $request->due_amount > 0 ?$request->due_amount:'Paid',
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param DebitVoucher $debitVoucher
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subShow(DebitVoucher $debitVoucher, Request $request)
    {
        $id  = $request->parent_id;
        $childHeads = Head::where('parent_id', $id)->with('parentHeads')->get();
        return response()->json([
            'childHeads' => $childHeads
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param DebitVoucher $debitVoucher
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function slipInfo(DebitVoucher $debitVoucher, Request $request)
    {
        $id  = $request->slip_id;
        $slip_id  = $request->slip_id;
        $slipInformation = Slip::where('id', $id)->get();
        $vendor_id  = $slipInformation[0]->vendor_id;
        $slipId = DebitVoucher::where('slip_id', $slip_id)->with('project', 'vendor', 'user', 'slip')->latest()->first();
        $projects = DB::select('SELECT DISTINCT
    (SELECT pro.id FROM projects pro WHERE pro.id = ven.project_id) AS id,
    (SELECT pro.project_name FROM projects pro WHERE pro.id = ven.project_id) AS project_name
FROM
    `slips` sl,
    `vendors` ven
WHERE
    sl.vendor_id = ven.id AND  sl.vendor_id = :vendor_id',['vendor_id' => $vendor_id]);
        return response()->json([
            'slipInformation' => $slipInformation,
            'slipId' => $slipId,
            'projects' => $projects
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param DebitVoucher $debitVoucher
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(DebitVoucher $debitVoucher, $id)
    {
//        $childHead = DB::selectOne('SELECT dv.*, h.head_name FROM `debit_vouchers` dv, heads h WHERE dv.`childhead_id` = h.id');
        $debit_vouchers = DebitVoucher::where('id', $id)->with('project', 'vendor', 'user', 'slip')->first();
        $slip = Slip::where('id', $debit_vouchers->slip->id)->with('vendor', 'debitVouchers', 'head', 'subhead')->first();
//        dd($slip);
        $debit_voucher = DebitVoucher::where('slip_id', $slip->id)->with('project', 'vendor', 'user', 'slip')->first();

        return response()->json([
            'debit_voucher', $debit_voucher,
            'slip', $slip,
            'debit_vouchers', $debit_vouchers
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param DebitVoucher $debitVoucher
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showHistory(Request $request, $id)
    {
        $debit_voucher = DebitVoucher::where('id', $id)->with('project', 'vendor', 'user', 'slip')->first();
        $debit_voucher_history_data = Project::where('id', $debit_voucher->project_id)->with('debitVouchers')->first();
        $debit_voucher_history = DebitVoucher::where('project_id', $debit_voucher_history_data->id)
            ->with('project', 'vendor', 'user', 'slip')
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['debit_voucher_history', $debit_voucher_history], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DebitVoucher  $debitVoucher
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(DebitVoucher $debitVoucher, $id)
    {
        $debit_voucher = DebitVoucher::with('project', 'vendor', 'user', 'head', 'subhead')->where('id', $id)->first();

        return response()->json(['debit_voucher', $debit_voucher], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DebitVoucher  $debitVoucher
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, DebitVoucher $debitVoucher)
    {
        $request->validate([
            'project_id' => 'required|numeric',
            'vendor_id' => 'required|numeric',
            'head_id' => 'required',
            'childhead_id' => 'required',
            'd_amount' => 'required'
        ]);
        $d_voucher = DebitVoucher::find($request->id);
        $d_voucher->project_id = $request->project_id;
        $d_voucher->vendor_id = $request->vendor_id;
        $d_voucher->head_id = $request->head_id;
        $d_voucher->childhead_id = $request->childhead_id;
        $d_voucher->d_amount = $request->d_amount;
        $d_voucher->user_id = Auth::id();
        if ($d_voucher->update()) {
            $success = true;
        }else{
            $success = false;
        }

        return response()->json(['success', $success], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DebitVoucher  $debitVoucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(DebitVoucher $debitVoucher)
    {
        //
    }
}

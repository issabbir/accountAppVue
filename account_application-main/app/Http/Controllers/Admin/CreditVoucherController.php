<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\CreditVoucher;
use App\Models\DebitVoucher;
use App\Models\Project;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreditVoucherController extends Controller
{
    public function index()
    {
        $c_voucher = CreditVoucher::with('project', 'client', 'user')->get();
        $debit_voucher = DebitVoucher::with('project', 'user', 'slip', 'vendor')->get();
        $debitAmount = $debit_voucher->mapToGroups(function ($item, $key) {
            return [$item['vendor_id'] => $item['d_amount']];
        });
        $d_voucher = DebitVoucher::with('project', 'user', 'slip', 'vendor')->get();
        $d_voucher = $d_voucher->keyBy('project_id');
        $d_voucher = $d_voucher->values()->all();
        $credit_voucher = CreditVoucher::with('project', 'client', 'user')->pluck('c_amount')->toArray();
        $dv_amount = DebitVoucher::with('project', 'user', 'slip', 'vendor')->pluck('d_amount')->toArray();
        $due_amount = DebitVoucher::with('project', 'client', 'user')->pluck('due_amount')->toArray();
        $dueAmount = collect($due_amount)->sum();
        $dVAmount = collect($dv_amount)->sum();
        $creditAmount = collect($credit_voucher)->sum();
        $creditDetails = DB::select('SELECT cv.*, pj.project_name FROM `credit_vouchers` cv, `projects` pj WHERE cv.`project_id` = pj.id');
        $projects = Project::all();
        $vendors = Vendor::all();
        $clients = Client::all();
        return response()->json([
            'c_voucher' => $c_voucher,
            'projects' => $projects,
            'clients' => $clients,
            'creditDetails' => $creditDetails,
            'creditAmount' => $creditAmount,
            'dVAmount' => $dVAmount,
            'vendors' => $vendors,
            'debit_voucher' => $debit_voucher,
            'dueAmount' => $dueAmount,
            'd_voucher' => $d_voucher
        ]);
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
            'c_amount' => 'required',
        ]);

         CreditVoucher::create([
            'project_id' => $request->project_id,
            'client_id' => $request->client_id,
            'c_amount' => $request->c_amount,
            'deposit_medium' => $request->deposit_medium,
            'p_name' => $request->p_name,
            'p_phone' => $request->p_phone,
            'b_name' => $request->b_name,
            'b_branch_name' => $request->b_branch_name,
            'b_acc_no' => $request->b_acc_no,
            'user_id' => Auth::id(),
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
        $credit_voucher = CreditVoucher::where('id', $id)->with('project', 'client', 'user')->first();

        return response()->json(['credit_voucher', $credit_voucher], 200);
    }
}

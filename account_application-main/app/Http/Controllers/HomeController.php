<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.layouts');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function debitedAmountPieChart()
    {
        $pie_chart = DB::select('SELECT
    SUM(dv.`d_amount`) AS value,
    pro.project_name as name
FROM
    `debit_vouchers` dv,
    projects pro
WHERE
    dv.`project_id` = pro.id
GROUP BY
    dv.project_id, pro.project_name');

        return response()->json(['pie_chart', $pie_chart], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function creditedAmountPieChart()
    {
        $pie_chart = DB::select('SELECT
	SUM(cv.c_amount) AS value,
    cl.c_name as name
FROM
    credit_vouchers cv,
    clients cl
WHERE
    cv.client_id = cl.id
GROUP BY
    cv.client_id, cl.c_name');

        return response()->json(['pie_chart', $pie_chart], 200);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $customers = Customer::all();
        return response()->json([
            'customers' => $customers
        ]);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'c_name' => 'required|min:5|max:100',
            'c_phone' => 'required|numeric',
            'c_email' => 'required|email',
            'c_address' => 'required',
            'c_remarks' => 'required'
        ]);

        $customer = new Customer;
        $customer->c_name = $request->c_name;
        $customer->c_phone = $request->c_phone;
        $customer->c_slug = slugify($request->c_name);
        $customer->c_email = $request->c_email;
        $customer->c_address = $request->c_address;
        $customer->c_type = $request->c_type;
        $customer->c_coupon_code = $request->c_coupon_code;
        $customer->c_remarks = $request->c_remarks;
        $customer->save();
//        Supplier::create([
//            's_name' => $request->s_name,
//            's_contact' => $request->s_contact,
//            's_email' => $request->s_email,
//            's_address' => $request->s_address,
//            's_remarks' => $request->s_remarks,
//            'slug' => slugify($request->s_name)
//        ]);
    }

    public function show()
    {
        $customer = Customer::where('slug', $slug)->first();

        return response()->json(['customer', $customer], 200);
    }
}

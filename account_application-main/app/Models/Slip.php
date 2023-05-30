<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    protected $fillable = ['vendor_id', 'head_id', 'debit_voucher_id', 'childhead_id', 'slip_code', 'company_name', 'slip_amount'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function debitVouchers()
    {
        return $this->hasMany(DebitVoucher::class, 'project_id', 'id');
    }

    public function head() {
        return $this->belongsTo(Head::class, 'head_id', 'id');
    }

    public function subhead() {
        return $this->belongsTo(Head::class, 'childhead_id', 'id', 'parent_id');
    }
}

<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class DebitVoucher extends Model
{
    protected $fillable = ['project_id', 'vendor_id', 'user_id', 'slip_id',
        'slip_amount', 'd_amount', 'due_amount'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

//    public function head() {
//        return $this->belongsTo(Head::class, 'head_id', 'id');
//    }
//
//    public function subhead() {
//        return $this->belongsTo(Head::class, 'childhead_id', 'id', 'parent_id');
//    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function slip() {
        return $this->belongsTo(Slip::class, 'slip_id', 'id', 'slip_id');
    }
}

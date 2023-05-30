<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = ['project_id',
        'v_name', 'v_phone', 'v_email',
        'v_address', 'v_type'];

    protected $primarykey ='id';

    public function project() {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function slip() {
        return $this->belongsTo(Slip::class, 'slip_id', 'id');
    }
    public function debitVoucher() {
        return $this->hasMany(DebitVoucher::class, 'vendor_id');
    }
}

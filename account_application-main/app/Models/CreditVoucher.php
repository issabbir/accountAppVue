<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class CreditVoucher extends Model
{
    protected $fillable = [
        'project_id', 'client_id', 'user_id', 'c_amount',
        'deposit_medium', 'p_name',
        'p_phone',  'b_name',
        'b_branch_name', 'b_acc_no'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}

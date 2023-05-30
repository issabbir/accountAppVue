<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['id', 'client_id', 'project_name', 'project_owner', 'owner_phone', 'owner_image', 'project_location'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function debitVouchers()
    {
        return $this->hasMany(DebitVoucher::class, 'project_id', 'id');
    }
    public function creditVouchers()
    {
        return $this->hasMany(CreditVoucher::class, 'project_id', 'id');
    }
}

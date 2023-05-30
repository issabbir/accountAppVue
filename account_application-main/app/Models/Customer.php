<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['c_name', 'c_contact', 'c_email', 'c_type', 'c_email',  'c_coupon_code', 'c_remarks', 'c_slug'];
}

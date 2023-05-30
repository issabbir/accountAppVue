<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['s_name', 's_company_name', 's_location', 's_contact', 's_email', 's_remarks', 'slug'];
}

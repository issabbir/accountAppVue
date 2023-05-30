<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'c_name', 'c_phone', 'c_email',
        'c_address', 'c_remarks'];
}

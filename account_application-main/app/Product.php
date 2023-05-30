<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'p_name', 'p_price', 'p_brand', 'p_quantity', 'p_barcode', 'p_status'];

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id','name','slug','remarks');
    }
}

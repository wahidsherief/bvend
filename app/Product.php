<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_category_id', 'product_brand_id', 'product_name', 'description',
        'color', 'weight', 'flavor', 'unit', 'image'
    ];

    public function category()
    {
        return $this->belongsTo('App\ProductCategory', 'product_category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo('App\ProductBrand', 'product_brand_id', 'id');
    }

    public function MLTransactionLocker()
    {
        return $this->hasMany('App\MLTransactionLocker');
    }
}

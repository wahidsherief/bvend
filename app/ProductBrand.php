<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    protected $table = 'product_brands';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'image'
    ];

    public function products()
    {
        return $this->hasMany('App\Product', 'id');
    }
}

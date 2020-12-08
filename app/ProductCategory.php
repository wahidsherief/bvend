<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany('App\Product', 'id');
    }
}

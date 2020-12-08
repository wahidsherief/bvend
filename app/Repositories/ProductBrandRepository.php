<?php

namespace App\Repositories;

use App\ProductBrand;

class ProductBrandRepository
{
    protected $product_brand;

    public function __construct(ProductBrand $product_brand)
    {
        $this->product_brand = $product_brand;
    }

    public function all()
    {
        return $this->product_brand->all();
    }

    public function get($item = 15)
    {
        return $this->product_brand->latest()->paginate($item);
    }

    public function find($id)
    {
        return $this->product_brand->findOrFail($id);
    }

    public function store(array $attributes)
    {
        return $this->product_brand->newInstance()->fill($attributes)->save();
    }

    public function update($id, array $attributes)
    {
        return $this->product_brand->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->product_brand->find($id)->delete();
    }
}

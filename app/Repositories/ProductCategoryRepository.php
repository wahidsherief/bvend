<?php

namespace App\Repositories;

use App\ProductCategory;

class ProductCategoryRepository
{
    protected $product_category;

    public function __construct(ProductCategory $product_category)
    {
        $this->product_category = $product_category;
    }

    public function all()
    {
        return $this->product_category->all();
    }

    public function get($item = 15)
    {
        return $this->product_category->latest()->paginate($item);
    }

    public function find($id)
    {
        return $this->product_category->findOrFail($id);
    }

    public function create()
    {
    }

    public function store(array $attributes)
    {
        return $this->product_category->newInstance()->fill($attributes)->save();
    }

    public function update($id, array $attributes)
    {
        return $this->product_category->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->product_category->find($id)->delete();
    }
}

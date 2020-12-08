<?php

namespace App\Repositories;

use App\Product;

class ProductRepository
{
    protected $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function all()
    {
        return $this->product->all();
    }

    public function get($paginate = 15)
    {
        return $this->product->with('category')->latest()->paginate($paginate);
    }

    public function find($id)
    {
        return $this->product->findOrFail($id);
    }

    public function store(array $attributes)
    {
        return $this->product->newInstance()->fill($attributes)->save();
    }

    public function update($id, array $attributes)
    {
        return $this->product->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->product->find($id)->delete();
    }
}

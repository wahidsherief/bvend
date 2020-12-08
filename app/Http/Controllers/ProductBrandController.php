<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductBrand\ProductBrandStoreRequest;
use App\Http\Requests\ProductBrand\ProductBrandUpdateRequest;
use App\Services\BaseService;
use App\Repositories\ProductBrandRepository;

class ProductBrandController extends Controller
{
    private $path = 'product_brand';

    public function __construct(ProductBrandRepository $product_brand, BaseService $service)
    {
        $this->middleware('auth:admin');
        $this->product_brand = $product_brand;
        $this->service = $service;
    }

    public function index()
    {
        $brands = $this->product_brand->get();

        return view('product.brand.index')->with('brands', $brands);
    }

    public function find($id)
    {
        return $this->product_brand->find($id);
    }

    public function create()
    {
        return view('product.brand.create');
    }

    public function store(ProductBrandStoreRequest $request)
    {
        $attributes = $this->service->processInputForStore($request->all(), $this->path);
        $stored = $this->product_brand->store($attributes);

        if (!$stored) {
            return redirect()->back()->with('error', 'Product brand creation failed!');
        }

        return redirect()->back()->with('success', 'Product brand created succesfully!');
    }

    public function edit($id)
    {
        $brand = $this->product_brand->find($id);

        return view('product.brand.edit')->with('brand', $brand);
    }

    public function update(ProductBrandUpdateRequest $request, $id)
    {
        $product_brand = $this->product_brand->find($id);
        $attributes = $this->service->processInputForUpdate($product_brand, $request->all(), $this->path);
        $updated = $this->product_brand->update($id, $attributes);

        if (!$updated) {
            return redirect()->back()->with('error', 'Product brand update failed !');
        }

        return redirect()->back()->with('success', 'Product brand updated succesfully!');
    }

    public function destroy($id)
    {
        $product_brand = $this->product_brand->find($id);

        $this->service->deleteImage($product_brand, $this->path);

        $destroyed = $this->product_brand->delete($id);

        if (!$destroyed) {
            return redirect()->back()->with('error', 'Product brand delete failed !');
        }

        return redirect()->back()->with('success', 'Product brand deleted succesfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\BaseService;
use App\Repositories\ProductRepository;
use App\Repositories\ProductBrandRepository;
use App\Repositories\ProductCategoryRepository;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;

class ProductController extends Controller
{
    private $path = 'product';

    public function __construct(ProductRepository $product, BaseService $service)
    {
        $this->middleware('auth:admin');
        $this->product = $product;
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->product->get(15);

        return view('product.index')->with('products', $products);
    }

    public function find($id)
    {
        return $this->product->find($id);
    }

    public function create(ProductBrandRepository $productbrand, ProductCategoryRepository $productcategory)
    {
        $productbrands = $productbrand->all();
        $productcategories = $productcategory->all();

        return view('product.create')->with('categories', $productcategories)->with('brands', $productbrands);
    }

    public function store(ProductStoreRequest $request)
    {
        $attributes = $this->service->processInputForStore($request->all(), $this->path);
        $stored = $this->product->store($attributes);

        if (!$stored) {
            return redirect()->back()->with('error', 'Product upload failed!');
        }

        return redirect()->back()->with('success', 'Product uploaded succesfully!');
    }

    public function edit($id, ProductBrandRepository $productbrand, ProductCategoryRepository $productcategory)
    {
        $product = $this->product->find($id);
        $productbrands = $productbrand->all();
        $productcategories = $productcategory->all();

        return view('product.edit')->with('categories', $productcategories)
            ->with('brands', $productbrands)
            ->with('product', $product);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = $this->product->find($id);
        $attributes = $this->service->processInputForUpdate($product, $request->all(), $this->path);
        $updated = $this->product->update($id, $attributes);

        if (!$updated) {
            return redirect()->back()->with('error', 'Product update failed !');
        }

        return redirect()->back()->with('success', 'Product updated succesfully!');
    }

    public function destroy($id)
    {
        $product = $this->product->find($id);

        $this->service->deleteImage($product, $this->path);

        $destroyed = $this->product->delete($id);

        if (!$destroyed) {
            return redirect()->back()->with('error', 'Product delete failed !');
        }

        return redirect()->back()->with('success', 'Product deleted succesfully!');
    }
}

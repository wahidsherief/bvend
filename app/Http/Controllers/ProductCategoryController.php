<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategory\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategory\ProductCategoryUpdateRequest;
use App\Services\BaseService;
use App\Repositories\ProductCategoryRepository;

class ProductCategoryController extends Controller
{
    public function __construct(ProductCategoryRepository $product_category, BaseService $service)
    {
        $this->middleware('auth:admin');
        $this->product_category = $product_category;
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->product_category->get();

        return view('product.category.index')->with('categories', $categories);
    }

    public function find($id)
    {
        return $this->product_category_categories->find($id);
    }

    public function create()
    {
        return view('product.category.create');
    }

    public function store(ProductCategoryStoreRequest $request)
    {
        $stored = $this->product_category->store($request->all());

        if (!$stored) {
            return redirect()->back()->with('error', 'Product category add failed!');
        }

        return redirect()->back()->with('success', 'Product category added succesfully!');
    }

    public function edit($id)
    {
        $category = $this->product_category->find($id);

        return view('product.category.edit')->with('category', $category);
    }

    public function update(ProductCategoryUpdateRequest $request, $id)
    {
        $updated = $this->product_category->update($id, $request->all());

        if (!$updated) {
            return redirect()->back()->with('error', 'Product category update failed !');
        }

        return redirect()->back()->with('success', 'Product category updated succesfully!');
    }

    public function destroy($id)
    {
        $destroyed = $this->product_category->delete($id);

        if (!$destroyed) {
            return redirect()->back()->with('error', 'Product category delete failed !');
        }

        return redirect()->back()->with('success', 'Product category deleted succesfully!');
    }
}

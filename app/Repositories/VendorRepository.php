<?php

namespace App\Repositories;

use App\Vendor;

class VendorRepository
{
    protected $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function get($item = 15)
    {
        return $this->vendor->latest()->paginate($item);
    }

    public function active($item = 15)
    {
        return $this->vendor->where('is_approved', '=', 1)->latest()->paginate($item);
    }

    public function inactive($item = 15)
    {
        return $this->vendor->where('is_approved', '=', 0)->latest()->paginate($item);
    }

    public function find($id)
    {
        return $this->vendor->findOrFail($id);
    }

    public function store(array $attributes)
    {
        return $this->vendor->newInstance()->fill($attributes)->save();
    }

    public function update($id, array $attributes)
    {
        return $this->vendor->find($id)->update($attributes);
    }

    public function delete($id)
    {
        return $this->vendor->find($id)->delete();
    }

    public function mltransaction($item)
    {
        return $this->vendor->mltransaction()->paginate($item);
    }

    public function mstransaction($item)
    {
        return $this->vendor->mstransaction()->paginate($item);
    }
}

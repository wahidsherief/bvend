<?php

namespace App\Services;

use App\Repositories\VendorRepository;
use Illuminate\Support\Facades\Hash;

class BaseService
{
    public function __construct(VendorRepository $vendor)
    {
        $this->vendor = $vendor;
    }

    public function processInputForStore($attributes, $image_path)
    {
        $name = strtolower(isset($attributes['name']) ? $attributes['name'] : 'unnammed');

        if (isset($attributes['image'])) {
            $path = config('global.' . $image_path . '_image_path');
            $image = $attributes['image'];
            $image_name = 'bvend-' . $image_path . '-' . $name . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $image_name);
            $attributes['image'] = $image_name;
        }

        return $this->checkInput($attributes);
    }

    public function processInputForUpdate($item, $attributes, $image_path)
    {
        $name = strtolower(isset($attributes['name']) ? $attributes['name'] : 'unnammed');

        if (isset($attributes['image'])) {
            $path = config('global.' . $image_path . '_image_path');
            $file = $path . $item->image;

            if (file_exists($file)) {
                unlink($file);
            }

            $image = $attributes['image'];
            $image_name = 'bvend-' . $image_path . '-' . $name . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $image_name);
            $attributes['image'] = $image_name;
        }

        return $this->checkInput($attributes);
    }

    private function checkInput($attributes)
    {
        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        if (isset($attributes['approved'])) {
            $attributes['is_approved'] = $attributes['approved'] == 'on' ? 1 : 0;
        }

        return $attributes;
    }

    public function deleteImage($item, $image_path)
    {
        $file = config('global.' . $image_path . '_image_path') . $item->image;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}

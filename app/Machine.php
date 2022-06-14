<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = 'machines';

    protected $fillable = [
        'vendor_id', 'no_of_channels', 'products_per_channel', 'machine_code', 'qr_code', 'address',
        'temperature', 'humidity', 'fan_status', 'maintainance', 'active'
    ];

    public function vendor()
    {
        return $this->hasMany('App\Vendor', 'id', 'vendor_id');
    }
}

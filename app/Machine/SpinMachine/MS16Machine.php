<?php

namespace App\Machine\SpinMachine;

use Illuminate\Database\Eloquent\Model;

class MS16Machine extends Model
{
    protected $table = 'ms_16_machines';

    protected $fillable = [
        'vendor_id', 'locker_start','locker_end', 'machine_code', 'qr_code',
        'temperature', 'humidity', 'fan_status', 'maintainance', 'active'
    ];
    
    public  function vendor(){
    	return $this->hasMany('App\Vendor','id','vendor_id');
    }
}

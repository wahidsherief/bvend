<?php

namespace App\Machine\SpinMachine;

use Illuminate\Database\Eloquent\Model;

class MS96Machine extends Model
{
    protected $table = 'ms_96_machines';

    protected $fillable = [
        'vendor_id', 'locker_start','locker_end', 'machine_code', 'qr_code',
        'temperature', 'humidity', 'fan_status', 'maintainance', 'active'
    ];
    
    public  function vendor(){
    	return $this->belongsTo('App\Vendor','id','vendor_id');
    }
}
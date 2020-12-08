<?php

namespace App\Machine\LockerMachine;

use Illuminate\Database\Eloquent\Model;

class ML32MachineLocker extends Model
{
    protected $table = 'ml_32_machine_lockers';

    protected $fillable = [
        'machine_id', 'product_id','status','maintainance'
    ];

    public function products() {
    	return $this->hasMany('App\Product');
    }
}
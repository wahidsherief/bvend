<?php

namespace App\Machine\LockerMachine;

use Illuminate\Database\Eloquent\Model;

class ML16MachineLocker extends Model
{
    protected $table = 'ml_16_machine_lockers';

    protected $fillable = [
        'machine_id', 'product_id','status','maintainance'
    ];

    public function products() {
    	return $this->hasMany('App\Product');
    }
}

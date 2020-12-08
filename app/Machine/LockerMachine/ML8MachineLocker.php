<?php

namespace App\Machine\LockerMachine;

use Illuminate\Database\Eloquent\Model;

class ML8MachineLocker extends Model
{
    protected $table = 'ml_8_machine_lockers';

    protected $fillable = [
        'machine_id', 'product_id','status','maintainance'
    ];

    public  function machine(){
    	return $this->hasOne('App\ML8MachineLocker','id','machine_id');
    }

    public function products() {
    	return $this->hasMany('App\Product');
    }
}

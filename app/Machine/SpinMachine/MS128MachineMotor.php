<?php

namespace App\Machine\SpinMachine;

use Illuminate\Database\Eloquent\Model;

class MS128MachineMotor extends Model
{
    protected $table = 'ms_128_machine_motors';

    protected $fillable = [
        'machine_id', 'product_id','status','maintainance'
    ];

    public function products() {
    	return $this->hasMany('App\Product');
    }
}

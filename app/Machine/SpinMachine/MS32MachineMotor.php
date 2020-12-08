<?php

namespace App\Machine\SpinMachine;

use Illuminate\Database\Eloquent\Model;

class MS32MachineMotor extends Model
{
    protected $table = 'ms_32_machine_motors';

    protected $fillable = [
        'machine_id', 'product_id','status','maintainance'
    ];

    public function products() {
    	return $this->hasMany('App\Product');
    }
}

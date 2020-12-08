<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refill extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'refills';

    protected $fillable = [
        'machine_id',
        'machine_type',
        'machine_model',
        'locker_id',
        'product_id',
        'quantity',
        'buy_unit_price',
        'sale_unit_price'
    ];

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

    public function locker()
    {
        return $this->belongsTo('App\TransactionLocker', 'refill_id', 'id');
    }
}

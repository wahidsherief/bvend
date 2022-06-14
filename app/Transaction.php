<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'machine_id', 'user_id', 'user_mobile', 'machine_model',
        'vendor_id', 'invoice_no', 'payment_id',
        'bkash_trx_id', 'total_amount', 'discount',
        'payment_method_id', 'status'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    // public function lockers()
    // {
    //     return $this->hasMany('App\TransactionLocker', 'transaction_id', 'id');
    // }

    public function vendor()
    {
        return $this->hasOne('App\Vendor', 'id', 'vendor_id');
    }
}

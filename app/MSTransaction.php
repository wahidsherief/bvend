<?php

	namespace App;

	use Illuminate\Database\Eloquent\Model;
	use App\Product;
	use DB;
	class MSTransaction extends Model
	{
	    protected $table = 'ms_transactions';

	    protected $fillable = [
	        'machine_id','user_id','motor_id','product_id','quantity','invoice_no','payment_id',
	        'bkash_trx_id','total_amount','discount',
	        'payment_method_id','status'
	    ];
	 


	 
}



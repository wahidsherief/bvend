<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Services\MachineService;
use DB;

class Admin extends Authenticatable
{
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'phone', 'image', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function salesReport($type, $model, $date)
    {
        $machine_service = new MachineService;
        $machine_table = $machine_service->getLockerMachineTable($model);
        $machines = DB::table($machine_table)->get();
        $i = 0;
        foreach ($machines as $machine) {
            $ml_transactions = DB::table('ml_transactions')
                                ->where([
                                    ['machine_id', '=', $machine->id],
                                    ['machine_model', '=', $model],
                                    ['status', '=', 'success']
                                ])->get();
            $total_sales_amount = 0;
            $total_sales_product = 0;
            // $sold_products = [];
            if ($ml_transactions->count() > 0) {
                foreach ($ml_transactions as $ml_transaction) {
                    $transaction_lockers = DB::table('transaction_lockers')
                                    ->join('ml_transactions', 'transaction_lockers.transaction_id', '=', 'ml_transactions.id')
                                    ->where('transaction_lockers.transaction_id', '=', $ml_transaction->id)
                                    ->where('ml_transactions.created_at', '>=', $date)
                                    ->get();
                    $total_sales_product += $transaction_lockers->count();
                    if ($transaction_lockers->count() > 0) {
                        foreach ($transaction_lockers as $transaction_locker) {
                            $refill = DB::table('refills')->where('refills.id', '=', $transaction_locker->refill_id)->first();
                            $total_sales_amount += $refill->sale_unit_price;
                            // array_push($sold_products, $refill->product_id);
                        }
                    }
                }
            }
            // $products = [];
            // $j=0;
            // $sorted_products = array_count_values($sold_products);
            // if($sorted_products) {
            //     foreach ($sorted_products as $id => $sorted_product) {
            //         $products[$j]['item'] = DB::table('products')->where('id', $id)->first();
            //         $products[$j]['count'] = $sorted_product;
            //     }
            // }

            $machines[$i]->total_sales_amount = $total_sales_amount;
            $machines[$i]->total_sales_product = $total_sales_product;
            // $machines[$i]->products = $products;

            $i++;
        }

        return $machines;
    }
}

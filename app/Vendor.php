<?php

namespace App;

use App\Services\MachineService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;

class Vendor extends Authenticatable
{
    use Notifiable;

    protected $guard = 'vendor';
    protected $primaryKey = 'id';
    protected $table = 'vendors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'image', 'password', 'business_name',
        'business_phone', 'trade_licence_no', 'bank_account_no', 'nid', 'otp', 'is_approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getID()
    {
        return $this->id;
    }

    public function category()
    {
        return $this->belongsTo('App\VendorCategory');
    }

    public function mltransaction()
    {
        return $this->hasMany('App\MLTransaction', 'vendor_id', 'id');
    }

    public function mstransaction()
    {
        return $this->hasMany('App\MSTransaction', 'vendor_id', 'id');
    }

    public function totalSalesAmount()
    {
        $vendor_id = Auth::id();
        $ml_machine_total_amount = MLTransaction::where('vendor_id', '=', $vendor_id)->sum('total_amount');
        $ms_machine_total_amount = MSTransaction::where('vendor_id', '=', $vendor_id)->sum('total_amount');

        return $ml_machine_total_amount + $ms_machine_total_amount;
    }

    public function salesReport($type, $model, $date)
    {
        $machine_service = new MachineService;
        $machine_table = $machine_service->getLockerMachineTable($model);
        $vendor_id = Auth::id();
        $machines = DB::table($machine_table)->where('vendor_id', '=', $vendor_id)->get();
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
            $sold_products = [];
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
                            array_push($sold_products, $refill->product_id);
                        }
                    }
                }
            }
            $products = [];
            $j = 0;
            $sorted_products = array_count_values($sold_products);
            if ($sorted_products) {
                foreach ($sorted_products as $id => $sorted_product) {
                    $products[$j]['item'] = DB::table('products')->where('id', $id)->first();
                    $products[$j]['count'] = $sorted_product;
                }
            }

            $machines[$i]->total_sales_amount = $total_sales_amount;
            $machines[$i]->total_sales_product = $total_sales_product;
            $machines[$i]->products = $products;

            $i++;
        }

        return $machines;
    }

    public function productSalesReport()
    {
        $vendor_id = Auth::id();
        $products = DB::table('refills')
                        ->join('products', 'refills.product_id', '=', 'products.id')
                        ->join('ml_8_machines', 'ml_8_machines.id', '=', 'refills.machine_id')
                        ->where('ml_8_machines.vendor_id', '=', $vendor_id)
                        ->get();
    }
}

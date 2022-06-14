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

    public function salesReport($date)
    {
        $transactions = DB::table('transactions')
                        ->where([['status', '=', 'success'],['transactions.created_at', '>=', $date]])
                        ->get()
                        ->groupBy('machine_id');
        return $transactions;
    }
}

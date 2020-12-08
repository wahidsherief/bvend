<?php

namespace App\Services;

use App\Http\Controllers\BkashController;

class PaymentService extends BaseService
{
    protected $bkash;

    public function __construct(BkashController $bkash)
    {
        $this->bkash = $bkash;
    }

    public function bkashSearchTransaction($trx_id)
    {
        return $this->bkash->searchTransaction($trx_id);
    }
}

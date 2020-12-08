<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class TransactionLocker extends Model
    {
        protected $table = 'transaction_lockers';

        protected $fillable = [
            'transaction_id', 'locker_id'
        ];

        public function refill()
        {
            return $this->hasOne('App\Refill', 'id', 'refill_id');
        }
    }
?>



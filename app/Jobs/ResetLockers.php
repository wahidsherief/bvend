<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\MachineService;

class ResetLockers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 0;

    protected $model;
    protected $machine_id;
    protected $locker_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $machine_id, $locker_id)
    {
        $this->model = $model;
        $this->machine_id = $machine_id;
        $this->locker_id = $locker_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $machine_service = new MachineService;
        $locker_table = $machine_service->getLockersTable($this->model);

        \DB::table($locker_table)->where([
            ['id', '=', $this->locker_id],
            ['machine_id', '=', $this->machine_id],
        ])->update(['status' => 'off']);

        echo 'hello done';
    }
}
///usr/local/bin/php/home2/courage/www.bvend.xyz/artisan queue:listen database --daemon

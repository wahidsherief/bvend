<?php

use Illuminate\Database\Seeder;

class MachineModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = ['8', '16', '32', '64', '96', '128', '256'];
        foreach ($models as $model) {	
        	DB::table('machine_models')->insert(['model' => $model]);
        }
    }
}

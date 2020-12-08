<?php

use Illuminate\Database\Seeder;

class MachineTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['ML', 'MS'];
        foreach ($types as $type) {
            DB::table('machine_types')->insert(['type' => $type]);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Organization extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->insert([
        	'name' => 'Brac',
        	'status' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

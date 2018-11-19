<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Status extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('status')->truncate();
        DB::table('status')->insert([
            'id' => '0',
            'vendor_id' => 0,
            'name' => 'NA',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::unprepared("UPDATE status SET id=0");
        DB::unprepared("ALTER TABLE status AUTO_INCREMENT=1;");



        DB::table('status')->insert([
            'name' => 'Raised',
            'vendor_id' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('status')->insert([
            'name' => 'Open Price',
            'vendor_id' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('status')->insert([
        	'name' => 'Request Rejected',
        	'vendor_id' => 0,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

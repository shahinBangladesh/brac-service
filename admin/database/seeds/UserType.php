<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class UserType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
        	'name' => 'Admin',
        	'org_id' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('user_types')->insert([
        	'name' => 'Branch Manager',
        	'org_id' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('user_types')->insert([
        	'name' => 'Approver',
        	'org_id' => 1,
        	'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

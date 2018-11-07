<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class VendorUserType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vendor_user_types')->insert([
            'name'=>'Admin',
            'vendor_id'=>0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        ]);
    }
}

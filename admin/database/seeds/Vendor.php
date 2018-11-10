<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Vendor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('vendors')->truncate();
        DB::table('vendors')->insert([
            'id' => '0',
            'vendor_user_type_id' => 1,
            'org_id' => 1,
            'name' => 'NA',
            'email' => 'NA@gmail.com',
            'password' => bcrypt('1'),
            'status' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::unprepared("UPDATE vendors SET id=0");
        DB::unprepared("ALTER TABLE vendors AUTO_INCREMENT=1;");
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'id' => '0',
            'user_type_id' => 1,
            'org_id' => 1,
            'name' => 'NA',
            'email' => 'NA@gmail.com',
            'password' => bcrypt('1'),
            'approverOrConsent' => 2,
            'branch_id' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::unprepared("UPDATE users SET id=0");
        DB::unprepared("ALTER TABLE users AUTO_INCREMENT=1;");


        DB::table('users')->insert([
            'user_type_id' => 1,
            'org_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1'),
            'approverOrConsent' => 1,
            'branch_id' => 0,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

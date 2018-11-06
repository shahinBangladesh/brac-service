<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Branch extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('branches')->truncate();
        DB::table('branches')->insert([
            'id' => '0',
            'org_id' => 1,
            'name'=>'N\A'
        ]);
        DB::unprepared("UPDATE branches SET id=0");
        DB::unprepared("ALTER TABLE branches AUTO_INCREMENT=1;");

        DB::table('branches')->insert([
            'org_id' => 1,
            'name' => 'Gulshan',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Organization::class);
        $this->call(UserType::class);
        $this->call(Branch::class);
        $this->call(Users::class);
        $this->call(ServiceType::class);
    }
}

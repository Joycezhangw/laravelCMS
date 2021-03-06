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
         $this->call(SysAlbumTableSeeder::class);
         $this->call(ManageTableSeeder::class);
         $this->call(ManageModuleTableSeeder::class);
         $this->call(SysDistrictTableSeeder::class);
    }
}

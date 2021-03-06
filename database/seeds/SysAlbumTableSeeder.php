<?php

use Illuminate\Database\Seeder;

class SysAlbumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('sys_album')->insert([
            [
                'pid' => 0,
                'album_name' => '默认相册',
                'album_sort' => 0,
                'album_cover' =>'',
                'is_default' =>1,
                'created_at' => time(),
                'updated_at' => time()
            ]
        ]);
    }
}

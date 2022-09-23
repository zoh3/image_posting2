<?php

use Illuminate\Database\Seeder;

class WoksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('works')->insert([
            'title' => Str::random(10),
            'comment' => Str::random(10),
            ]);
    }
}

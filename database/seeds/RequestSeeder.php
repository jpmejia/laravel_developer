<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('requests')->insert([
	   'url' => 'https://atomic.incfile.com/fakepost',
	   'method' => 'post',
	   'parameters' => json_encode([]),
           'send' => false,
           'code' => 0,
	   'body' => ''
	]);
    }
}

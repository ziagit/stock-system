<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExtrasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('extras')->insert([
            'vat' => 0,
            'logo' => 'no logo',
            'favicon' => "no icon",
            'phone' => 'no phon',
            'email' => 'no email',
            'address'=>'no address'
        ]);
       
    }
}

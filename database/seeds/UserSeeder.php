<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user           = new User();
        $user->name     = 'Michael';
        $user->surname  = 'Dojčár';
        $user->name_5   = 'Michaeli';
        $user->email    = 'michaeldojcar@gmail.com';
        $user->phone    = '734791909';
        $user->password = bcrypt('secret');

        $user->save();
    }
}

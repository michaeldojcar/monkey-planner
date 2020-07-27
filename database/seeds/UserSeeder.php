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
        $user = new User();
        $user->name = "Administrátor";
        $user->surname = "Administrátor";
        $user->name_5 = "Administrátor";
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('secret');
        $user->save();
    }
}

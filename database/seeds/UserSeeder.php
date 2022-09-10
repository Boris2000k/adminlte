<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seeder for testing purposes
        //Adds users to the database with random permissions 
        $permissions = array('user-management,','import-orders,','import-refunds,','user-management,import-orders,','','import-orders,user-management,import-refunds,',);
        
        for($i=0;$i<30;$i++)
        {
            User::create([
            'username' => 'user_'.$i.'',
            'password' => Hash::make('123123'),
            'permissions' => $permissions[array_rand($permissions)],
            ]);

        }
    }
}

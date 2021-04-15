<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->first_name = "admin";
        $user->last_name = "admin";
        $user->email = "admin@thawb.com";
        $user->password = Hash::make('admin@123');
        $user->role_id = '1';
        $user->save();

        $user = new User();
        $user->first_name = "User";
        $user->last_name = "User";
        $user->email = "user@thawb.com";
        $user->password = Hash::make('user@123');
        $user->role_id = '2';
        $user->device_id = '12345useruser';
        $user->device_token = '12345useruser';
        $user->device_type = 'ios';
        $user->social_id = '12345useruserfacebook';
        $user->social_type = 'facebook';
        $user->save();
    }
}

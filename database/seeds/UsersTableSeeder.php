<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Cria o usuário admin
        $user = new User;
        $user->name = 'Admin';
        $user->email = 'admin@ecomp.co';
        $user->admin = true;
        $user->email_verified_at = true;
        $user->password = bcrypt('secret');
        $user->save();

        // $user = new User;
        // $user->name = 'User';
        // $user->email = 'user@ecomp.co';
        // $user->email_verified_at = true;
        // $user->password = bcrypt('secret');
        // $user->save();
        // factory(App\User::class, 10)->create();
    }
}

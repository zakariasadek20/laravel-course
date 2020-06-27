<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $NbrUsers=(int)$this->command->ask('How many of user you want generate ?',10);
        
        factory(App\User::class,$NbrUsers)->create();

    }
}

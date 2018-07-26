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
        DB::table('users')->insert([
            'name' => 'Usuário Teste',
            'email' => 'user@teste.com',
            'password' => bcrypt('teste123'),
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->insert([
            ['name' => 'Gabriel García Márquez', 'nationality' => 'Colombiano', 'birth_date' => '1927-03-06'],
            ['name' => 'Isabel Allende', 'nationality' => 'Chilena', 'birth_date' => '1942-08-02'],
            ['name' => 'Miguel de Cervantes', 'nationality' => 'Español', 'birth_date' => '1547-09-29']
        ]);
    }
}

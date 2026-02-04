<?php

use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('books')->insert([
        [
            'title' => 'Cien años de soledad', 
            'year' => 1967, 
            'isbn' => '978-0307474728', 
            'author_id' => 1,
            'description' => 'La historia de la familia Buendía.'
        ],
        [
            'title' => 'Don Quijote de la Mancha', 
            'year' => 1605, 
            'isbn' => '978-8420412146', 
            'author_id' => 3,
            'description' => 'Las aventuras de un caballero andante.'
        ]
    ]);
  }
}

<?php

namespace AppMyIntelli;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'nationality', 'cant_libros'];

    public function books()
    {
        // Esta es la función que te falta y que causa el error 500
        return $this->hasMany('AppMyIntelli\Book', 'author_id');
    }
}
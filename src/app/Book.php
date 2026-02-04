<?php

namespace AppMyIntelli;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'year',
        'isbn'
    ];

    public function author()
    {
        return $this->belongsTo('AppMyIntelli\Author', 'author_id');
    }
}

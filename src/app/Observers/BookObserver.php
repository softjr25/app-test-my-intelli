<?php

namespace AppMyIntelli\Observers;

use AppMyIntelli\Book;
use AppMyIntelli\Jobs\UpdateAuthorBookCount;

class BookObserver
{
    // Se dispara justo después de que un libro se guarda en la DB
    public function created(Book $book)
    {
        UpdateAuthorBookCount::dispatch($book->author_id);
    }

    // Opcional: También actualiza si se elimina un libro
    public function deleted(Book $book)
    {
        UpdateAuthorBookCount::dispatch($book->author_id);
    }
}
<?php

namespace AppMyIntelli\Jobs;

use AppMyIntelli\Author;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateAuthorBookCount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $authorId;

    public function __construct($authorId)
    {
        $this->authorId = $authorId;
    }

    public function handle()
    {
        $author = Author::find($this->authorId);
        if ($author) {
            // Actualizamos el campo cant_libros con el conteo actual de la relación
            $author->cant_libros = $author->books()->count();
            $author->save();
        }
    }
}
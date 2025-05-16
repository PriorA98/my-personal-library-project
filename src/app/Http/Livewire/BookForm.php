<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Author;
use App\Book;

class BookForm extends Component
{
    public $title;
    public $author;

    protected $rules = [
        'title' => 'required|string',
        'author' => 'required|string',
    ];

    public function submit()
    {
        $this->validate($this->rules);

        $author = Author::firstOrCreate(['name' => $this->author]);

        $exists = Book::where('title', $this->title)
            ->where('author_id', $author->id)
            ->exists();

        if ($exists) {
            $this->addError('title', 'This author already has a book with this title.');
            return;
        }

        Book::create([
            'title' => $this->title,
            'author_id' => $author->id,
        ]);

        $this->reset(['title', 'author']);

        $this->emit('bookAdded');
    }

    public function render()
    {
        return view('livewire.book-form');
    }
}

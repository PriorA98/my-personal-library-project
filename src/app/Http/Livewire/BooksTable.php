<?php

namespace App\Http\Livewire;

use App\Author;
use Livewire\Component;
use App\Book;

class BooksTable extends Component
{
    public $books;
    public $editAuthorId = null;
    public $newAuthorName = '';


    protected $listeners = ['bookAdded' => 'refreshBooks'];
    protected $rules = [
        'newAuthorName' => 'required|string',
    ];


    public function mount()
    {
        $this->refreshBooks();
    }

    public function refreshBooks()
    {
        $this->books = Book::with('author')->get();
    }

    public function deleteBook($id)
    {
        Book::findOrFail($id)->delete();
        $this->refreshBooks();
    }

    public function render()
    {
        return view('livewire.books-table');
    }

    public function editAuthor($authorId, $currentName)
    {
        $this->editAuthorId = $authorId;
        $this->newAuthorName = $currentName;
    }

    public function saveAuthor()
    {
        $this->validate([
            'newAuthorName' => 'required|string|max:255',
        ]);

        $author = Author::findOrFail($this->editAuthorId);
        $author->name = $this->newAuthorName;
        $author->save();

        $this->editAuthorId = null;
        $this->newAuthorName = '';

        $this->refreshBooks();
    }

}

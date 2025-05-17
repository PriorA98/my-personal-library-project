<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BookService;
use App\Services\AuthorService;

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
        $this->books = app(BookService::class)->getAllBooksWithAuthors();
    }

    public function deleteBook($id)
    {
        app(BookService::class)->deleteBookById($id);
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

        app(AuthorService::class)->updateAuthorName($this->editAuthorId, $this->newAuthorName);

        $this->editAuthorId = null;
        $this->newAuthorName = '';

        $this->refreshBooks();
    }

}

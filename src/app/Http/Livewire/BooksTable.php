<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Book;

class BooksTable extends Component
{
    public $books;

    protected $listeners = ['bookAdded' => 'refreshBooks'];

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
}

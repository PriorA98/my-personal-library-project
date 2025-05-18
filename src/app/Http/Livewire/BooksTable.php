<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BookService;

class BooksTable extends Component
{
    public $books;
    public $editingField = null;
    public $editingValue = '';

    protected $listeners = ['bookAdded' => 'refreshBooks'];

    public function mount()
    {
        $this->refreshBooks();
    }

    public function refreshBooks()
    {
        $bookService = app(BookService::class);
        $this->books = $bookService->getAllBooksWithAuthors();
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

    public function startEditing($model, $id, $field, $value)
    {
        $this->editingField = compact('model', 'id', 'field');
        $this->editingValue = $value;
    }

    public function saveEdit()
    {
        $this->validate([
            'editingValue' => 'required|string|max:255',
        ]);

        $handler = app('editable.' . $this->editingField['model']);
        $handler->updateField(
            $this->editingField['id'],
            $this->editingField['field'],
            $this->editingValue
        );

        $this->editingField = null;
        $this->editingValue = '';
        $this->refreshBooks();
    }
}

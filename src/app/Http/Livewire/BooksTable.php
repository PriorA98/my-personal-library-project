<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BookService;

class BooksTable extends Component
{
    public $books;
    public $editingField = null;
    public $editingValue = '';
    public $sortField;
    public $sortDirection;
    public $search;

    protected $listeners = [
        'bookAdded' => 'refreshBooks',
        'updateSort' => 'applySort',
    ];

    public function mount($sortField, $sortDirection, $search = '')
    {
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
        $this->search = $search;
        $this->refreshBooks();
    }

    public function refreshBooks()
    {
        $this->books = app(BookService::class)->getBooksWithAuthorsFilteredAndSorted(
            $this->search,
            $this->sortField,
            $this->sortDirection
        );
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
    public function applySort($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
        $this->refreshBooks();
    }
}

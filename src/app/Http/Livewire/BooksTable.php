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

        $model = $this->editingField['model'];
        $field = $this->editingField['field'];
        $id = $this->editingField['id'];

        switch ("$model-$field") {
            case 'book-title':
                $handlerKey = 'editable.book-title';
                break;
            case 'author-name':
                $handlerKey = 'editable.author-name';
                break;
            case 'book-author':
                $handlerKey = 'editable.book-author-name';
                break;
            default:
                throw new \InvalidArgumentException("No handler for $model-$field");
        }

        app($handlerKey)->updateField($id, $field, $this->editingValue);

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

    protected function isEditing(string $model, int $id, string $field): bool
    {
        return $this->editingField &&
            $this->editingField['model'] === $model &&
            $this->editingField['id'] === $id &&
            $this->editingField['field'] === $field;
    }

    public function isEditingBookTitle($book): bool
    {
        return $this->isEditing('book', $book->id, 'title');
    }

    public function isEditingAuthorName($book): bool
    {
        return $this->isEditing('author', $book->author->id, 'name');
    }

    public function isEditingBookAuthorName($book): bool
    {
        return $this->isEditing('book', $book->id, 'author');
    }

}

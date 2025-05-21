<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Book;
use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksTableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_books_exist_when_component_mounts_then_books_are_loaded()
    {
        // Arrange
        $author = Author::create(['name' => 'Author A']);
        Book::create(['title' => 'Title A', 'author_id' => $author->id]);

        // Act & Assert
        Livewire::test('books-table', [
            'sortField' => 'title',
            'sortDirection' => 'asc',
            'search' => '',
        ])->assertViewHas('books', function ($books) {
            return $books->count() === 1 && $books->first()->title === 'Title A';
        });
    }

    /** @test */
    public function given_book_id_when_deleteBook_called_then_book_is_deleted()
    {
        // Arrange
        $author = Author::create(['name' => 'To Delete']);
        $book = Book::create(['title' => 'To Remove', 'author_id' => $author->id]);

        // Act
        Livewire::test('books-table', [
            'sortField' => 'title',
            'sortDirection' => 'asc',
        ])->call('deleteBook', $book->id);

        // Assert
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /** @test */
    public function given_editing_state_when_saveEdit_then_handler_is_called_and_state_resets()
    {
        // Arrange
        $author = Author::create(['name' => 'Old Name']);
        $book = Book::create(['title' => 'Old Title', 'author_id' => $author->id]);

        // Bind fake handler
        app()->bind('editable.book-title', fn() => new class {
            public function updateField($id, $field, $value)
                {
                    $book = Book::findOrFail($id);
                    $book->$field = $value;
                    $book->save();
                }
            });

        // Act & Assert
        Livewire::test('books-table', [
            'sortField' => 'title',
            'sortDirection' => 'asc',
        ])
            ->set('editingField', ['model' => 'book', 'id' => $book->id, 'field' => 'title'])
            ->set('editingValue', 'New Title')
            ->call('saveEdit')
            ->assertSet('editingField', null)
            ->assertSet('editingValue', '');

        $this->assertDatabaseHas('books', ['title' => 'New Title']);
    }

    /** @test */
    public function given_invalid_input_when_saveEdit_then_validation_error_is_thrown()
    {
        // Arrange
        $author = Author::create(['name' => 'A']);
        $book = Book::create(['title' => 'B', 'author_id' => $author->id]);

        Livewire::test('books-table', [
            'sortField' => 'title',
            'sortDirection' => 'asc',
        ])
            ->set('editingField', ['model' => 'book', 'id' => $book->id, 'field' => 'title'])
            ->set('editingValue', '')
            ->call('saveEdit')
            ->assertHasErrors(['editingValue' => 'required']);
    }

    /** @test */
    public function given_sort_event_when_applySort_is_called_then_books_are_sorted()
    {
        // Arrange
        $author = Author::create(['name' => 'Z']);
        Book::create(['title' => 'B', 'author_id' => $author->id]);
        Book::create(['title' => 'A', 'author_id' => $author->id]);

        // Act
        Livewire::test('books-table', [
            'sortField' => 'title',
            'sortDirection' => 'desc',
        ])
            ->call('applySort', 'title', 'asc')
            ->assertViewHas('books', function ($books) {
                return $books->first()->title === 'A';
            });
    }
}

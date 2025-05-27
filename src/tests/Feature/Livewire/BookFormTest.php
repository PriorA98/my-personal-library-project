<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use App\Author;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_valid_input_when_submit_then_book_is_created_and_fields_reset()
    {
        // Arrange
        $title = 'New Book';
        $author = 'Author Name';

        // Act & Assert
        Livewire::test('book-form')
            ->set('title', $title)
            ->set('author', $author)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('title', '')
            ->assertSet('author', '')
            ->assertEmitted('bookAdded');

        $this->assertDatabaseHas('books', ['title' => $title]);
        $this->assertDatabaseHas('authors', ['name' => $author]);
    }

    /** @test */
    public function given_missing_fields_when_submit_then_validation_errors_are_returned()
    {
        Livewire::test('book-form')
            ->call('submit')
            ->assertHasErrors(['title' => 'required', 'author' => 'required']);
    }

    /** @test */
    public function given_duplicate_title_for_same_author_when_submit_then_validation_error_from_service_is_returned()
    {
        // Arrange
        $author = Author::create(['name' => 'Dup Author']);
        Book::create(['title' => 'Dup Title', 'author_id' => $author->id]);

        Livewire::test('book-form')
            ->set('title', 'Dup Title')
            ->set('author', 'Dup Author')
            ->call('submit')
            ->assertHasErrors(['title']);
    }
}

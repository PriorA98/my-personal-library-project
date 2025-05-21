<?php

namespace Tests\Unit\FieldEditors;

use Tests\TestCase;
use App\Book;
use App\Author;
use App\Services\AuthorService;
use App\FieldEditors\BookAuthorNameEditor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class BookAuthorNameEditorTest extends TestCase
{
    use RefreshDatabase;

    protected BookAuthorNameEditor $editor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->editor = new BookAuthorNameEditor(app(AuthorService::class));
    }

    /** @test */
    public function given_new_author_name_when_updateField_then_book_gets_new_author()
    {
        // Arrange
        $oldAuthor = Author::create(['name' => 'Old']);
        $book = Book::create(['title' => 'The Book', 'author_id' => $oldAuthor->id]);

        // Act
        $this->editor->updateField($book->id, 'author', 'New Author');

        // Assert
        $this->assertDatabaseHas('authors', ['name' => 'New Author']);
        $this->assertEquals('New Author', $book->fresh()->author->name);
    }

    /** @test */
    public function given_duplicate_title_when_updateField_then_throws_validation_exception()
    {
        $this->expectException(ValidationException::class);

        $authorA = Author::create(['name' => 'Author A']);
        $authorB = Author::create(['name' => 'Author B']);

        Book::create(['title' => 'Shared Title', 'author_id' => $authorB->id]);
        $book = Book::create(['title' => 'Shared Title', 'author_id' => $authorA->id]);

        $this->editor->updateField($book->id, 'author', 'Author B');
    }

    /** @test */
    public function given_invalid_field_when_updateField_then_throws_invalid_argument_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $author = Author::create(['name' => 'Author']);
        $book = Book::create(['title' => 'Invalid', 'author_id' => $author->id]);

        $this->editor->updateField($book->id, 'wrong', 'X');
    }
}

<?php

namespace Tests\Unit\FieldEditors;

use Tests\TestCase;
use App\Book;
use App\Author;
use App\FieldEditors\BookTitleEditor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class BookTitleEditorTest extends TestCase
{
    use RefreshDatabase;

    protected BookTitleEditor $editor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->editor = new BookTitleEditor();
    }

    /** @test */
    public function given_valid_title_when_updateField_then_book_title_is_updated()
    {
        // Arrange
        $author = Author::create(['name' => 'Author']);
        $book = Book::create(['title' => 'Old', 'author_id' => $author->id]);

        // Act
        $this->editor->updateField($book->id, 'title', 'New Title');

        // Assert
        $this->assertEquals('New Title', $book->fresh()->title);
    }

    /** @test */
    public function given_duplicate_title_when_updateField_then_throws_validation_exception()
    {
        $this->expectException(ValidationException::class);

        $author = Author::create(['name' => 'Author']);
        Book::create(['title' => 'Existing', 'author_id' => $author->id]);
        $book = Book::create(['title' => 'Original', 'author_id' => $author->id]);

        $this->editor->updateField($book->id, 'title', 'Existing');
    }

    /** @test */
    public function given_invalid_field_when_updateField_then_throws_invalid_argument_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        $author = Author::create(['name' => 'Author']);
        $book = Book::create(['title' => 'Test', 'author_id' => $author->id]);

        $this->editor->updateField($book->id, 'invalid', 'Ignored');
    }
}

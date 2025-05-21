<?php

namespace Tests\Unit\FieldEditors;

use Tests\TestCase;
use App\Book;
use App\Author;
use App\Services\AuthorService;
use App\FieldEditors\AuthorNameEditor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class AuthorNameEditorTest extends TestCase
{
    use RefreshDatabase;

    protected AuthorNameEditor $editor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->editor = new AuthorNameEditor(app(AuthorService::class));
    }

    /** @test */
    public function given_valid_field_and_name_when_updateField_then_author_is_renamed()
    {
        // Arrange
        $author = Author::create(['name' => 'Old']);
        Book::create(['title' => 'Some Book', 'author_id' => $author->id]);

        // Act
        $this->editor->updateField($author->id, 'name', 'New Name');

        // Assert
        $this->assertDatabaseHas('authors', ['name' => 'New Name']);
    }

    /** @test */
    public function given_invalid_field_when_updateField_then_throws_invalid_argument_exception()
    {
        $this->expectException(\InvalidArgumentException::class);

        // Arrange
        $author = Author::create(['name' => 'Original']);
        Book::create(['title' => 'X', 'author_id' => $author->id]);

        // Act
        $this->editor->updateField($author->id, 'wrong_field', 'Value');
    }

    /** @test */
    public function given_author_with_no_books_when_updateField_then_throws_runtime_exception()
    {
        $this->expectException(RuntimeException::class);

        $author = Author::create(['name' => 'Lonely']);

        $this->editor->updateField($author->id, 'name', 'Anything');
    }

    /** @test */
    public function given_duplicate_book_title_when_updateField_then_throws_validation_exception()
    {
        $this->expectException(ValidationException::class);

        $author1 = Author::create(['name' => 'A']);
        $author2 = Author::create(['name' => 'B']);

        Book::create(['title' => 'Same Title', 'author_id' => $author1->id]);
        Book::create(['title' => 'Same Title', 'author_id' => $author2->id]);

        $this->editor->updateField($author1->id, 'name', 'B');
    }
}

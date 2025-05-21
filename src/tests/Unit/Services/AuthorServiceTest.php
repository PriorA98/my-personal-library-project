<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\AuthorService;
use App\Author;
use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(AuthorService::class);
    }

    /** @test */
    public function given_author_with_no_books_when_deleteIfOrphaned_then_author_is_deleted()
    {
        // Arrange
        $author = Author::create(['name' => 'Orphan']);

        // Act
        $this->service->deleteIfOrphaned($author->id);

        // Assert
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }

    /** @test */
    public function given_author_with_books_when_deleteIfOrphaned_then_author_is_not_deleted()
    {
        // Arrange
        $author = Author::create(['name' => 'Writer']);
        Book::create([
            'title' => 'Book One',
            'author_id' => $author->id,
        ]);

        // Act
        $this->service->deleteIfOrphaned($author->id);

        // Assert
        $this->assertDatabaseHas('authors', ['id' => $author->id]);
    }
}

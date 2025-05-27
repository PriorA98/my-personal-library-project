<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Book;
use App\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_existing_book_with_same_title_and_author_when_isDuplicateTitleForAuthor_then_returns_true()
    {
        // Arrange
        $author = Author::create(['name' => 'Author']);
        Book::create(['title' => 'My Book', 'author_id' => $author->id]);

        // Act
        $isDuplicate = Book::isDuplicateTitleForAuthor($author->id, 'My Book');

        // Assert
        $this->assertTrue($isDuplicate);
    }

    /** @test */
    public function given_existing_book_but_different_author_when_isDuplicateTitleForAuthor_then_returns_false()
    {
        // Arrange
        $author1 = Author::create(['name' => 'Author 1']);
        $author2 = Author::create(['name' => 'Author 2']);

        Book::create(['title' => 'Unique Book', 'author_id' => $author1->id]);

        // Act
        $isDuplicate = Book::isDuplicateTitleForAuthor($author2->id, 'Unique Book');

        // Assert
        $this->assertFalse($isDuplicate);
    }

    /** @test */
    public function given_existing_book_when_isDuplicateTitleForAuthor_excluding_its_id_then_returns_false()
    {
        // Arrange
        $author = Author::create(['name' => 'Author']);
        $book = Book::create(['title' => 'Exclude Me', 'author_id' => $author->id]);

        // Act
        $isDuplicate = Book::isDuplicateTitleForAuthor($author->id, 'Exclude Me', $book->id);

        // Assert
        $this->assertFalse($isDuplicate);
    }

    /** @test */
    public function given_no_matching_book_when_isDuplicateTitleForAuthor_then_returns_false()
    {
        // Arrange
        $author = Author::create(['name' => 'New Author']);

        // Act
        $isDuplicate = Book::isDuplicateTitleForAuthor($author->id, 'Nonexistent Title');

        // Assert
        $this->assertFalse($isDuplicate);
    }
}

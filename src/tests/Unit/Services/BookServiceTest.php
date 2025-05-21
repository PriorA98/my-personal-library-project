<?php

namespace Tests\Unit\Services;

use App\Book;
use App\Author;
use Tests\TestCase;
use App\Services\BookService;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BookService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(BookService::class);
    }

    /** @test */
    public function given_book_id_when_deleteBookById_then_book_is_deleted()
    {
        // Arrange
        $author = Author::create(['name' => 'Test Author']);
        $book = Book::create([
            'title' => 'Delete Me',
            'author_id' => $author->id,
        ]);

        // Act
        $this->service->deleteBookById($book->id);

        // Assert
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /** @test */
    public function given_non_existing_book_title_and_author_when_deleteBookById_then_validation_exception_is_thrown()
    {
        // Arrange
        $bookId = 999; // Assuming this ID does not exist

        // Act & Assert
        $this->expectException(ModelNotFoundException::class);
        $this->service->deleteBookById($bookId);
    }

    /** @test */
    public function given_valid_title_and_author_when_createBook_then_book_is_created()
    {
        // Arrange
        $title = 'Clean Code';
        $authorName = 'Robert C. Martin';

        // Act
        $book = $this->service->createBook($title, $authorName);

        // Assert
        $this->assertDatabaseHas('books', ['title' => $title]);
        $this->assertEquals($authorName, $book->author->name);
    }

    /** @test */
    public function given_existing_author_when_createBook_then_does_not_duplicate_author()
    {
        // Arrange
        $author = Author::create(['name' => 'Martin']);
        $title = 'Refactoring';

        // Act
        $book = $this->service->createBook($title, $author->name);

        // Assert
        $this->assertEquals(1, Author::where('name', 'Martin')->count());
        $this->assertEquals('Martin', $book->author->name);
    }

    /** @test */
    public function given_existing_book_title_and_author_when_createBook_then_validation_exception_is_thrown()
    {
        // Arrange
        $authorName = 'Martin';
        $title = 'Clean Architecture';

        // Act
        $this->service->createBook($title, $authorName);

        // Assert
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The given data was invalid.');

        $this->service->createBook($title, $authorName);
    }



    /** 
     * @test
     * @dataProvider sortOptionsProvider
     */
    public function given_sort_options_when_getBooksWithAuthorsFilteredAndSorted_then_returns_expected_order($sortField, $sortDirection, $expectedFirstTitle)
    {
        // Arrange
        $authorA = Author::create(['name' => 'Alice']);
        $authorB = Author::create(['name' => 'Bob']);

        Book::create(['title' => 'Alpha Book', 'author_id' => $authorB->id]);
        Book::create(['title' => 'Zebra Book', 'author_id' => $authorA->id]);

        // Act
        $results = $this->service->getBooksWithAuthorsFilteredAndSorted('Book', $sortField, $sortDirection);

        // Assert
        $this->assertEquals($expectedFirstTitle, $results->first()->title);
    }


    public function sortOptionsProvider(): array
    {
        return [
            'author asc' => ['author', 'asc', 'Zebra Book'],
            'author desc' => ['author', 'desc', 'Alpha Book'],
            'title asc' => ['title', 'asc', 'Alpha Book'],
            'title desc' => ['title', 'desc', 'Zebra Book'],
        ];
    }

}

<table border="1">
    <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($books as $book)
            <tr>
                <td>{{ $book->title }}</td>
                <td>
                    @if ($editAuthorId === $book->author->id)
                        <input type="text" wire:model.defer="newAuthorName" />
                        <button wire:click="saveAuthor">💾</button>
                    @else
                        {{ $book->author->name }}
                        <button
                            wire:click="editAuthor({{ $book->author->id }}, '{{ addslashes($book->author->name) }}')">✏️</button>
                    @endif
                </td>
                <td>
                    <button wire:click="deleteBook({{ $book->id }})" onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">No books found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

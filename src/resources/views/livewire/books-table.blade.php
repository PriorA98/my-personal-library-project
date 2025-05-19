<div>
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 1em;">

            @foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach

        </div>
    @endif
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Edit</th>
                <th>Author</th>
                <th colspan="2">Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>
                        @if ($this->isEditingBookTitle($book))
                            <input type="text" wire:model.defer="editingValue">
                        @else
                            {{ $book->title }}
                        @endif
                    </td>
                    <td>
                        @if ($this->isEditingBookTitle($book))
                            <button wire:click="saveEdit">💾</button>
                        @else
                            <button
                                wire:click="startEditing('book', {{ $book->id }}, 'title', '{{ addslashes($book->title) }}')"
                                title="Edit title">✏️</button>
                        @endif
                    </td>

                    <td>
                        @if ($this->isEditingAuthorName($book) || $this->isEditingBookAuthorName($book))
                            <input type="text" wire:model.defer="editingValue">
                        @else
                            {{ $book->author->name }}
                        @endif
                    </td>
                    <td>
                        @if ($this->isEditingAuthorName($book))
                            <button wire:click="saveEdit">💾</button>
                        @else
                            <button
                                wire:click="startEditing('author', {{ $book->author->id }}, 'name', '{{ addslashes($book->author->name) }}')"
                                title="Edit all books by this author">📝</button>
                        @endif
                    </td>
                    <td>
                        @if ($this->isEditingBookAuthorName($book))
                            <button wire:click="saveEdit">💾</button>
                        @else
                            <button
                                wire:click="startEditing('book', {{ $book->id }}, 'author', '{{ addslashes($book->author->name) }}')"
                                title="Change author only for this book">✏️</button>
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
                    <td colspan="6">No books found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

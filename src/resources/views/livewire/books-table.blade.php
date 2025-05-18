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
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($books as $book)
                <tr>
                    <td>
                        @if (
                            $editingField &&
                                $editingField['model'] === 'book' &&
                                $editingField['id'] === $book->id &&
                                $editingField['field'] === 'title')
                            <input type="text" wire:model.defer="editingValue">
                        @else
                            {{ $book->title }}
                        @endif
                    </td>
                    <td>
                        @if (
                            $editingField &&
                                $editingField['model'] === 'book' &&
                                $editingField['id'] === $book->id &&
                                $editingField['field'] === 'title')
                            <button wire:click="saveEdit">💾</button>
                        @else
                            <button
                                wire:click="startEditing('book', {{ $book->id }}, 'title', '{{ addslashes($book->title) }}')">✏️</button>
                        @endif
                    </td>

                    <td>
                        @if (
                            $editingField &&
                                $editingField['model'] === 'author' &&
                                $editingField['id'] === $book->author->id &&
                                $editingField['field'] === 'name')
                            <input type="text" wire:model.defer="editingValue">
                        @else
                            {{ $book->author->name }}
                        @endif
                    </td>
                    <td>
                        @if (
                            $editingField &&
                                $editingField['model'] === 'author' &&
                                $editingField['id'] === $book->author->id &&
                                $editingField['field'] === 'name')
                            <button wire:click="saveEdit">💾</button>
                        @else
                            <button
                                wire:click="startEditing('author', {{ $book->author->id }}, 'name', '{{ addslashes($book->author->name) }}')">✏️</button>
                        @endif
                    </td>

                    <td>
                        <button wire:click="deleteBook({{ $book->id }})"
                            onclick="return confirm('Are you sure?')">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No books found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

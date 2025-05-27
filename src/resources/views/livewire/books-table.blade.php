<div class="box table-scroll-container">
    @if ($errors->any())
        @livewire('alert', ['message' => $errors->first(), 'type' => 'danger'], key('books-table-alert'))
    @endif

    <div class="table-wrapper">
        <table class="library-table">
            <thead>
                <tr>
                    <th class="title-cell header-cell">Title</th>
                    <th class="icon-cell header-cell"></th>
                    <th class="author-cell header-cell">Author</th>
                    <th class="icon-cell header-cell"></th>
                    <th class="icon-cell header-cell"></th>
                    <th class="icon-cell header-cell"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        {{-- Title --}}
                        <td class="title-cell" title="{{ $book->title }}">
                            @if ($this->isEditingBookTitle($book))
                                <input type="text" wire:model.defer="editingValue">
                            @else
                                {{ $book->title }}
                            @endif
                        </td>
                        <td class="icon-cell">
                            @if ($this->isEditingBookTitle($book))
                                <button wire:click="saveEdit" title="Save title">
                                    <span class="icon-btn">{!! svg_icon('Save') !!}</span>
                                </button>
                            @else
                                <button
                                    wire:click="startEditing('book', {{ $book->id }}, 'title', '{{ addslashes($book->title) }}')"
                                    title="Edit title">
                                    <span class="icon-btn">{!! svg_icon('Edit') !!}</span>
                                </button>
                            @endif
                        </td>

                        {{-- Author --}}
                        <td class="author-cell" title="{{ $book->author->name }}">
                            @if ($this->isEditingAuthorName($book) || $this->isEditingBookAuthorName($book))
                                <input type="text" wire:model.defer="editingValue">
                            @else
                                {{ $book->author->name }}
                            @endif
                        </td>

                        {{-- Edit author only for this book --}}
                        <td class="icon-cell">
                            @if ($this->isEditingBookAuthorName($book))
                                <button wire:click="saveEdit" title="Save author (this book only)">
                                    <span class="icon-btn">{!! svg_icon('Save') !!}</span>
                                </button>
                            @else
                                <button
                                    wire:click="startEditing('book', {{ $book->id }}, 'author', '{{ addslashes($book->author->name) }}')"
                                    title="Change author only for this book">
                                    <span class="icon-btn">{!! svg_icon('Edit') !!}</span>
                                </button>
                            @endif
                        </td>

                        {{-- Edit all books by this author --}}
                        <td class="icon-cell">
                            @if ($this->isEditingAuthorName($book))
                                <button wire:click="saveEdit" title="Save all author changes">
                                    <span class="icon-btn">{!! svg_icon('Save') !!}</span>
                                </button>
                            @else
                                <button
                                    wire:click="startEditing('author', {{ $book->author->id }}, 'name', '{{ addslashes($book->author->name) }}')"
                                    title="Edit all books by this author">
                                    <span class="icon-btn">{!! svg_icon('EditAll') !!}</span>
                                </button>
                            @endif
                        </td>



                        {{-- Delete --}}
                        <td class="icon-cell">
                            <button wire:click="deleteBook({{ $book->id }})"
                                onclick="return confirm('Are you sure?')" title="Delete book">
                                <span class="icon-btn">{!! svg_icon('Trash') !!}</span>
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
</div>

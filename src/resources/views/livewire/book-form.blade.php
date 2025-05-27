<form wire:submit.prevent="submit">
    @if ($errors->any())
        @livewire('alert', ['message' => $errors->first(), 'type' => 'danger'], key('book-form-alert'))
    @endif

    <label for="title">Enter the book's title:</label>
    <input type="text" id="title" wire:model="title" required>
    <br>

    <label for="author">Enter the author's name:</label>
    <input type="text" id="author" wire:model="author" required>
    <br>

    <button type="submit" class="btn-black full-width">ADD</button>
</form>

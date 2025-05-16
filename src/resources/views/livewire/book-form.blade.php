<form wire:submit.prevent="submit">
    <label for="title">Title:</label>
    <input type="text" id="title" wire:model="title" required>
    @error('title') <div class="alert alert-danger">{{ $message }}</div> @enderror
    <br>

    <label for="author">Author:</label>
    <input type="text" id="author" wire:model="author" required>
    @error('author') <div class="alert alert-danger">{{ $message }}</div> @enderror
    <br>

    <button type="submit">ADD</button>
</form>

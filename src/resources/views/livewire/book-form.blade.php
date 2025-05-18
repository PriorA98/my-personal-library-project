<form wire:submit.prevent="submit">
    @if ($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 1em;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <label for="title">Title:</label>
    <input type="text" id="title" wire:model="title" required>
    <br>

    <label for="author">Author:</label>
    <input type="text" id="author" wire:model="author" required>
    <br>

    <button type="submit">ADD</button>
</form>

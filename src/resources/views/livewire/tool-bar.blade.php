<div style="margin: 10px 0; display: flex; gap: 10px;">
    <input type="text" wire:model="search" placeholder="Search by title or author" />

    <button wire:click="sortBy('title')">
        Sort by Title ({{ $this->sortLabel('title') }})
    </button>

    <button wire:click="sortBy('author')">
        Sort by Author ({{ $this->sortLabel('author') }})
    </button>

    <button wire:click="resetSort">Reset</button>
    
    {{-- todo: implement --}}
    <button disabled>Export (Coming Soon)</button>
</div>

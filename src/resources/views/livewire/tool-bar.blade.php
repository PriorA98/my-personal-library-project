<div class="tool-bar">
    <div class="search-container">
        <input type="text" wire:model="search" placeholder="Search by title or author" class="search-input"/>
        <button wire:click="$set('search', '')" class="clear-search" data-has-content="{{ $search ? 'true' : 'false' }}" title="{{ $search ? 'Clear search' : 'Search' }}">
            <span class="icon-btn">{!! $search ? svg_icon('Close') : svg_icon('Search') !!}</span>
        </button>
    </div>
    
    <div class="buttons-container">
        <button wire:click="sortBy('title')" class="btn-black">
            Sort by Title ({{ $this->sortLabel('title') }})
        </button>

        <button wire:click="sortBy('author')" class="btn-black">
            Sort by Author ({{ $this->sortLabel('author') }})
        </button>

        <button wire:click="resetSort" class="btn-black">Reset</button>
    </div>
</div>

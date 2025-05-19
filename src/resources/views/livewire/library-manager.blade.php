<div>
    @livewire('tool-bar', ['sortField' => $sortField, 'sortDirection' => $sortDirection])
    @livewire(
        'books-table',
        [
            'sortField' => $sortField,
            'sortDirection' => $sortDirection,
            'search' => $search,
        ],
        key($sortField . $sortDirection . $search)
    )
</div>

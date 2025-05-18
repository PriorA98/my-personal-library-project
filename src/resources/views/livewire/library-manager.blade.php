<div>
    @livewire('tool-bar', ['sortField' => $sortField, 'sortDirection' => $sortDirection])
    @livewire('books-table', ['sortField' => $sortField, 'sortDirection' => $sortDirection], key($sortField . $sortDirection))
</div>

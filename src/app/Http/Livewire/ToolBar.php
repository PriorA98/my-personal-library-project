<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToolBar extends Component
{
    public $sortField;
    public $sortDirection;

    public function mount($sortField, $sortDirection)
    {
        $this->sortField = $sortField;
        $this->sortDirection = $sortDirection;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->emitUp('updateSort', $this->sortField, $this->sortDirection);
    }

    public function resetSort()
    {
        $this->sortField = 'title';
        $this->sortDirection = 'asc';
        $this->emitUp('updateSort', $this->sortField, $this->sortDirection);
    }

    public function render()
    {
        return view('livewire.tool-bar');
    }

    public function sortLabel(string $field): string
    {
        if ($this->sortField === $field) {
            return $this->sortDirection === 'asc' ? 'A-Z' : 'Z-A';
        }

        return 'A-Z';
    }

}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LibraryManager extends Component
{
    public $sortField = 'title';
    public $sortDirection = 'asc';

    protected $listeners = ['updateSort'];

    public function updateSort($field, $direction)
    {
        $this->sortField = $field;
        $this->sortDirection = $direction;
    }

    public function render()
    {
        return view('livewire.library-manager');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Alert extends Component
{
    public $message;
    public $type = 'danger';

    public function mount($message = '', $type = 'danger')
    {
        $this->message = $message;
        $this->type = $type;
    }

    public function render()
    {
        return view('livewire.alert');
    }
}

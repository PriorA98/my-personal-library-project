<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\BookService;
use Illuminate\Validation\ValidationException;

class BookForm extends Component
{
    public $title;
    public $author;

    protected $rules = [
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
    ];

    public function submit()
    {
        $this->validate($this->rules);

        try {
            app(BookService::class)->createBook($this->title, $this->author);
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
            return;
        }

        $this->reset(['title', 'author']);

        $this->emit('bookAdded');
    }

    public function render()
    {
        return view('livewire.book-form');
    }
}

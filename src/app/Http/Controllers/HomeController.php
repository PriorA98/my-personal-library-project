<?php

namespace App\Http\Controllers;

use App\Book;
use App\Author;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homepage()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
        ]);

        $author = Author::firstOrCreate(['name' => $request->author]);

        $duplicate = Book::where('title', $request->title)
            ->where('author_id', $author->id)
            ->exists();

        if ($duplicate) {
            return redirect('/')
                ->withErrors(['title' => 'This book is already stored in your library.'])
                ->withInput();
        }

        Book::create([
            'title' => $request->title,
            'author_id' => $author->id,
        ]);

        return redirect('/');
    }
}

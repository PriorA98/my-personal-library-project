<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LibraryManagerTest extends TestCase
{
    use RefreshDatabase;
    
    
    /** @test */
    public function given_initial_state_when_updateSort_then_sort_fields_are_updated()
    {
        Livewire::test('library-manager')
            ->call('updateSort', 'author', 'desc')
            ->assertSet('sortField', 'author')
            ->assertSet('sortDirection', 'desc');
    }

    /** @test */
    public function given_initial_state_when_updateSearch_then_search_value_is_set()
    {
        Livewire::test('library-manager')
            ->call('updateSearch', 'laravel')
            ->assertSet('search', 'laravel');
    }
}

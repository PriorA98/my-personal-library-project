<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToolBarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function given_field_when_sortBy_then_field_and_direction_are_updated()
    {
        Livewire::test('tool-bar', ['sortField' => 'title', 'sortDirection' => 'asc'])
            ->call('sortBy', 'author')
            ->assertSet('sortField', 'author')
            ->assertSet('sortDirection', 'asc');
    }

    /** @test */
    public function given_same_field_twice_when_sortBy_then_direction_is_toggled()
    {
        Livewire::test('tool-bar', ['sortField' => 'title', 'sortDirection' => 'asc'])
            ->call('sortBy', 'title')
            ->assertSet('sortDirection', 'desc');
    }

    /** @test */
    public function when_resetSort_then_defaults_and_emit_are_triggered()
    {
        Livewire::test('tool-bar', ['sortField' => 'author', 'sortDirection' => 'desc', 'search' => 'code'])
            ->call('resetSort')
            ->assertSet('sortField', 'title')
            ->assertSet('sortDirection', 'asc')
            ->assertSet('search', '');
    }
}

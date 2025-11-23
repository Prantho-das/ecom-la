<?php

namespace Tests\Feature\Livewire\Admin;

use Livewire\Volt\Volt;
use Tests\TestCase;

class StockInPageTest extends TestCase
{
    public function test_it_can_render(): void
    {
        $component = Volt::test('admin.stock-in-page');

        $component->assertSee('');
    }
}

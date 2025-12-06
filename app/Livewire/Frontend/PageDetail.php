<?php

namespace App\Livewire\Frontend;

use App\Models\Page;
use Livewire\Component;

class PageDetail extends Component
{
    public Page $page;

    public function mount(Page $page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.frontend.page-detail', [
            'page' => $this->page,
        ])->layout('layouts.frontend');
    }
}

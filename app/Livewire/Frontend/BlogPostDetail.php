<?php

namespace App\Livewire\Frontend;

use App\Models\Post;
use Livewire\Component;

class BlogPostDetail extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        return view('livewire.frontend.blog-post-detail', [
            'post' => $this->post,
        ])->layout('layouts.frontend');
    }
}

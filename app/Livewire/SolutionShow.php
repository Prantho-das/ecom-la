<?php

namespace App\Livewire;

use App\Models\Solution;
use Livewire\Component;
use Livewire\WithFileUploads;

class SolutionShow extends Component
{

    use WithFileUploads;

    public $slug;

    // Contact Form Properties
    public $firstName = '';
    public $lastName = '';
    public $email = '';
    public $phone = '';
    public $company = '';
    public $country = '';
    public $zip = '';
    public $comment = '';
    public $consent = false;

    public $successMessage = false;


    public function mount($slug)
    {
        $this->slug = $slug;
    }

    public function submitContactForm()
    {
        $this->validate([
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'email'     => 'required|email',
            'country'   => 'required',
            'consent'   => 'accepted', // requires checkbox to be checked
        ]);

        // Here you can save to a new Inquiry model or send email
        // Example: Inquiry::create([...]);

        $this->successMessage = true;

        // Reset form
        $this->reset([
            'firstName',
            'lastName',
            'email',
            'phone',
            'company',
            'country',
            'zip',
            'comment',
            'consent'
        ]);
    }
    public function render()
    {
        $page = Solution::where('page_slug', $this->slug)->firstOrFail();
        return view('livewire.solution-show', [
            'page' => $page
        ]);
    }
}

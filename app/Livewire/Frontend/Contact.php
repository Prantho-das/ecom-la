<?php

namespace App\Livewire\Frontend;

use App\Models\Contact as ModelsContact;
use Livewire\Component;

class Contact extends Component
{
    public $firstName = '';

    public $lastName = '';

    public $email = '';

    public $phone = '';

    public $message = '';

    public function save()
    {
        $this->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'message' => 'required',
        ]);

        ModelsContact::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ]);

        session()->flash('success', 'Your message has been sent successfully!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.frontend.contact');
    }
}

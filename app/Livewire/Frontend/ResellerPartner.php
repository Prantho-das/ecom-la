<?php

namespace App\Livewire\Frontend;

use App\Models\Reseller;
use Livewire\Component;

class ResellerPartner extends Component
{
    public function render()
    {
        $resellers = Reseller::where('status', 'active')->get();

        return view('livewire.frontend.reseller-partner', [
            'resellers' => $resellers,
        ]);
    }
}

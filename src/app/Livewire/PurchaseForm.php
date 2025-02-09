<?php

namespace App\Livewire;

use Livewire\Component;

class PurchaseForm extends Component
{
    public $paymentMethod='';
    public $item;
    public $profile;

    public function mount($item, $profile)
    {
        $this->item=$item;
        $this->profile=$profile;
    }

    public function render()
    {
        return view('livewire.purchase-form');
    }
}

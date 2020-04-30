<?php

namespace App\Http\Livewire;

use App\Repositories\Interfaces\CharityRepositoryInterface;
use Livewire\Component;

class CreateTransferCalculationComponent extends Component
{
    public $transferAmount;
    public $amountToBeCharged;
    public $charities;

    public function mount(CharityRepositoryInterface $charityRepository){
        $this->transferAmount = 0.00;
        $this->amountToBeCharged = '0.00';
        $this->charities = $charityRepository->getAllActiveCharities();
    }

    public function updatingTransferAmount($value){
        $fmt = numfmt_create( 'en_GB', \NumberFormatter::CURRENCY );
        if ($value){
            $this->amountToBeCharged = numfmt_format_currency ( $fmt , round($value + ($value*(2.7/100)) + 0.5, 2) , 'GBP' );
        } else {
            $this->value = 0;
            $this->amountToBeCharged = numfmt_format_currency ( $fmt , $this->value , 'GBP' );
        }
    }

    public function render()
    {
        return view('livewire.create-transfer-calculation-component');
    }
}

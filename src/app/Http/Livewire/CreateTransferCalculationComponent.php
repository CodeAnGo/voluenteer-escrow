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
        if ($value){
            $this->amountToBeCharged = sprintf('%01.2f', '%i', round($value + ($value*(2.7/100)) + 0.5, 2));
        } else {
            $this->value = 0;
            $this->amountToBeCharged = money_format('%i', $this->value);
        }
    }

    public function render()
    {
        return view('livewire.create-transfer-calculation-component');
    }
}

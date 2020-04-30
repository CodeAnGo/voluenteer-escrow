<?php

namespace App\Http\Livewire;

use App\Models\Transfer;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use Livewire\Component;

class TransferDeliveryInformationComponent extends Component
{
    public $transfer;

    public function mount(Transfer $transfer){
        $this->transfer = $transfer;
    }

    public function render()
    {
        return view('livewire.transfer-delivery-information-component');
    }

    public function rerender(TransferRepositoryInterface $transferRepository){
        $this->transfer = $transferRepository->getTransferFromID($this->transfer->id);
    }
}

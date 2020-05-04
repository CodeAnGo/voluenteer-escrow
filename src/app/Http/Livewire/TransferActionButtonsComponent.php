<?php

namespace App\Http\Livewire;

use App\Models\Transfer;
use App\Models\TransferDispute;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use Livewire\Component;

class TransferActionButtonsComponent extends Component
{
    public $transfer;

    public function mount(Transfer $transfer){
        $this->transfer = $transfer;
    }

    public function rerender(TransferRepositoryInterface $transferRepository){
        $this->transfer = $transferRepository->getTransferFromID($this->transfer->id);
    }

    public function render()
    {
        return view('livewire.transfer-action-buttons-component');
    }
}

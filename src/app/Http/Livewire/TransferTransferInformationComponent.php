<?php

namespace App\Http\Livewire;

use App\Helpers\StatusHelper;
use App\Models\Transfer;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use Livewire\Component;

class TransferTransferInformationComponent extends Component
{
    use StatusHelper;
    public $transfer;
    public $closedStatuses;
    public $statuses;
    public $transfer_files;

    public function mount(Transfer $transfer){
        $this->transfer = $transfer;
        $this->closedStatuses = $this->getClosedStatus();
        $this->statuses = $this->getStatusMap();
        $this->transfer_files = $transfer->transferFile;
    }

    public function rerender(TransferRepositoryInterface $transferRepository){
        $this->transfer = $transferRepository->getTransferFromID($this->transfer->id);
    }

    public function render()
    {
        return view('livewire.transfer-transfer-information-component');
    }
}

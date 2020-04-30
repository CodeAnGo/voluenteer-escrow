<?php

namespace App\Http\Livewire;

use App\Helpers\StatusHelper;
use App\Models\Transfer;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use App\User;
use Livewire\Component;

class TransferTransferHistoryComponent extends Component
{
    use StatusHelper;
    public $transfer;
    public $transferHistory;
    public $statuses;
    public $closedStatuses;

    public function mount(Transfer $transfer){
        $this->transfer = $transfer;
        $this->transferHistory = $transfer->audits()->with('user')->get();
        $this->statuses = $this->getStatusMap();
        $this->closedStatuses = $this->getClosedStatus();
    }

    public function render()
    {
        return view('livewire.transfer-transfer-history-component');
    }

    public function rerender(TransferRepositoryInterface $transferRepository){
        $this->transfer = $transferRepository->getTransferFromID($this->transfer->id);
        $this->transferHistory = $this->transfer->audits()->with('user')->get();
    }
}

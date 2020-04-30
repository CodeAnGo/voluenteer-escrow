<?php

namespace App\Http\Livewire;

use App\Helpers\StatusHelper;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AllTransfersComponent extends Component
{
    use StatusHelper;
    public $transfers;
    public $statuses;
    public $closedStatuses;


    public function mount(TransferRepositoryInterface $transferRepository){
        $this->transfers = $transferRepository->getAllTransfersForUser(Auth::user());
        $this->statuses = $this->getStatusMap();
        $this->closedStatuses = $this->getClosedStatus();
    }

    public function render()
    {
        return view('livewire.all-transfers-component');
    }

    public function rerender(TransferRepositoryInterface $transferRepository){
        $this->transfers = $transferRepository->getAllTransfersForUser(Auth::user());
    }
}

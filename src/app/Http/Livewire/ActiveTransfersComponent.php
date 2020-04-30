<?php

namespace App\Http\Livewire;

use App\Helpers\StatusHelper;
use App\Repositories\Interfaces\TransferRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ActiveTransfersComponent extends Component
{
    use StatusHelper;
    public $statuses;
    public $activeTransfers;


    public function mount(TransferRepositoryInterface $transferRepository){
        $this->activeTransfers = $transferRepository->getAllTransfersForUser(Auth::user(), true);
        $this->statuses = $this->getStatusMap();
    }

    public function render()
    {
        return view('livewire.active-transfers-component');
    }

    public function rerender(TransferRepositoryInterface $transferRepository){
        $this->activeTransfers = $transferRepository->getAllTransfersForUser(Auth::user(), true);
    }
}

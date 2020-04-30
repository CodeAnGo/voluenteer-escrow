<?php

namespace App\Http\Livewire;

use App\Models\Transfer;
use Livewire\Component;

class TransferHeaderComponent extends Component
{
    public $transfer;

    protected $listeners = [
        'stateUpdated' => 'rerender',
    ];

    public function mount(Transfer $transfer){
        $this->transfer = $transfer;
    }

    public function render()
    {
        return view('livewire.transfer-header-component');
    }

    public function rerender(){
        $this->transfer = Transfer::where('id', $this->transfer->id)->first();
    }
}

<?php

namespace App\Livewire;

use App\Models\PartnerUser;
use Livewire\Component;

class PartnerModal extends Component
{
    public $show = false;
    public $partnerUser;
    public $partner;
    public $users = [];

    protected $listeners = [
        'open-view-partner' => 'open'
    ];

    public function open($id)
    {
        $this->partnerUser = PartnerUser::with(['user', 'partner'])
            ->where('partner_id', $id)
            ->get();
        if ($this->partnerUser->isNotEmpty()) {
            $this->partner = $this->partnerUser->first()->partner;
            $this->users = $this->partnerUser->pluck('user')->filter();
            $this->show = true;
        }
    }

    public function render()
    {
        return view('livewire.partner-modal');
    }
}

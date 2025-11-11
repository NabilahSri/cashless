<?php

namespace App\Livewire;

use App\Models\Merchant;
use App\Models\Partner;
use Illuminate\Validation\Rule;
use Livewire\Component;

class MerchantModal extends Component
{
    public $show = false;
    public $mode = 'create';
    public $merchantId = null;
    public $name;
    public $partner_id;
    public $device_id;

    protected $listeners = [
        'open-merchant-modal' => 'open',
        'open-edit-merchant' => 'openEdit'
    ];

    public function open()
    {
        $this->mode = 'create';
        $this->resetValidation();
        $this->reset(['name', 'partner_id', 'device_id']);
        $this->show = true;
        $this->dispatch('reinit-hs-select');
    }

    public function openEdit($id)
    {
        $this->resetValidation();
        $this->mode = 'edit';
        $this->merchantId = $id;
        $merchant = Merchant::findOrFail($id);
        $this->name = $merchant->name;
        $this->partner_id = $merchant->partner_id;
        $this->device_id = $merchant->device_id;
        $this->show = true;
        $this->dispatch('reinit-hs-select');
    }

    public function save()
    {
        if ($this->mode === 'create') {
            $this->validate([
                'partner_id' => 'required|exists:partners,id',
                'name' => 'required',
                'device_id' => 'required|integer|unique:merchants,device_id',
            ]);
            Merchant::create([
                'partner_id' => $this->partner_id,
                'name' => $this->name,
                'device_id' => $this->device_id
            ]);
            $this->dispatch('success', message: 'Lokasi berhasil ditambahkan.');
        } else {
            $this->validate([
                'partner_id' => 'required|exists:partners,id',
                'name' => 'required',
                'device_id' => 'required|integer|unique:merchants,device_id,' . $this->merchantId,
            ]);
            $merchant = Merchant::findOrFail($this->merchantId);
            $data = [
                'partner_id' => $this->partner_id,
                'name' => $this->name,
                'device_id' => $this->device_id
            ];
            $merchant->update($data);
            $this->dispatch('success', message: 'Lokasi berhasil diupdate.');
        }
        $this->show = false;
        $this->dispatch('refreshDatatable')->to(MerchantTable::class);
    }

    public function render()
    {
        $partner = Partner::all();
        return view('livewire.merchant-modal', ['partner' => $partner]);
    }
}

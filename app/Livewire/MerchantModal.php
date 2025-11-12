<?php

namespace App\Livewire;

use App\Models\Merchant;
use App\Models\Partner;
use Illuminate\Support\Str;
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

    // 🔥 Fungsi ini jalan otomatis saat dropdown partner berubah
    public function updatedPartnerId($value)
    {
        $this->generateDeviceId($value);
        $this->dispatch('reinit-hs-select');
    }

    public function generateDeviceId($partnerId)
    {
        if ($partnerId) {
            $partner = Partner::find($partnerId);
            if ($partner) {
                $slug = \Illuminate\Support\Str::slug($partner->name, '-');
                $count = Merchant::where('partner_id', $partner->id)->count() + 1;
                $formatted = str_pad($count, 4, '0', STR_PAD_LEFT);

                $this->device_id = "{$slug}-{$formatted}";
            } else {
                $this->device_id = '';
            }
        } else {
            $this->device_id = '';
        }
    }


    public function save()
    {
        $this->validate([
            'partner_id' => 'required|exists:partners,id',
            'name' => 'required',
            'device_id' => 'required|unique:merchants,device_id,' . $this->merchantId,
        ]);

        if ($this->mode === 'create') {
            Merchant::create([
                'partner_id' => $this->partner_id,
                'name' => $this->name,
                'device_id' => $this->device_id
            ]);
            $this->dispatch('success', message: 'Lokasi berhasil ditambahkan.');
        } else {
            $merchant = Merchant::findOrFail($this->merchantId);
            $merchant->update([
                'partner_id' => $this->partner_id,
                'name' => $this->name,
                'device_id' => $this->device_id
            ]);
            $this->dispatch('success', message: 'Lokasi berhasil diupdate.');
        }

        $this->show = false;
        $this->dispatch('refreshDatatable')->to(MerchantTable::class);
    }

    public function render()
    {
        $partner = Partner::all();
        return view('livewire.merchant-modal', compact('partner'));
    }
}

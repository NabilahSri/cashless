<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TransactionModal extends Component
{
    public $showModal = false;
    public $memberId;
    public $member;
    public $nominal;
    public $deskripsi;
    public $transactionType = '';
    public $currentBalance = 0;

    protected $listeners = ['openTransactionModal' => 'show'];

    public function show()
    {
        $this->resetInput();
        $this->showModal = true;
    }

    public function close()
    {
        $this->showModal = false;
    }

    public function resetInput()
    {
        $this->memberId = '';
        $this->member = null;
        $this->nominal = '';
        $this->deskripsi = '';
        $this->transactionType = '';
        $this->currentBalance = 0;
    }

    public function findMember()
    {
        $this->member = Member::where('member_no', $this->memberId)->first();
        $this->currentBalance = 0;

        if (!$this->member) {
            session()->flash('error', 'Member tidak ditemukan.');
            $this->member = null;
        } else {
            $wallet = Wallet::where('member_id', $this->member->id)->first();

            if ($wallet) {
                $this->currentBalance = $wallet->balance ?? 0;
            }
        }
    }

    public function saveTransaction()
    {
        $user = Auth::user()->id;

        if (!$this->member) {
            session()->flash('error', 'Silakan cari member terlebih dahulu.');
            return;
        }

        $this->validate([
            'nominal' => 'required|numeric|min:1',
            'transactionType' => 'required|string',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::where('member_id', $this->member->id)->first();
        if (!$wallet) {
            session()->flash('error', 'Gagal! Wallet untuk member ini tidak ditemukan.');
            return;
        }

        $partnerUser = PartnerUser::where('user_id', $user)->first();
        if (!$partnerUser) {
            session()->flash('error', 'Gagal! Akun Anda tidak terhubung dengan partner.');
            return;
        }

        $merchant = Merchant::where('partner_id', $partnerUser->partner_id)->first();
        if (!$merchant) {
            session()->flash('error', 'Gagal! Merchant untuk partner Anda tidak ditemukan.');
            return;
        }

        // Cek saldo sebelum pembayaran
        if ($this->transactionType === 'payment' && $this->nominal > $wallet->balance) {
            session()->flash('error', 'Transaksi Gagal! Saldo member tidak mencukupi (Saldo: Rp ' . number_format($wallet->balance, 0, ',', '.') . ').');
            return;
        }

        try {
            // Generate ID Transaksi
            $datePart = now()->format('dmY');
            $todayCount = Transaction::whereDate('created_at', today())->count();
            $numberPart = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);
            $generatedTrxId = 'TRX' . $datePart . $numberPart;

            // Simpan transaksi
            $transaction = Transaction::create([
                'trx_id' => $generatedTrxId,
                'wallet_id' => $wallet->id,
                'merchant_id' => $merchant->id,
                'type' => $this->transactionType,
                'amount' => $this->nominal,
                'description' => $this->deskripsi,
                'user_id' => $user,
            ]);

            // Update saldo wallet
            if ($this->transactionType === 'topup') {
                $wallet->balance += $this->nominal;
            } elseif ($this->transactionType === 'payment') {
                $wallet->balance -= $this->nominal;
            }

            $wallet->save();

            $this->dispatch('success', message: 'Transaksi berhasil disimpan.');
            $this->dispatch('refreshDatatable');
            $this->close();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $cekDefault = '';

        if (auth()->user()->role == 'pengelola') {
            $cekPartner = PartnerUser::where('user_id', Auth::user()->id)->first();
            $cekDefault = Partner::where('id', $cekPartner->partner_id)->first();
        }

        return view('livewire.transaction-modal', ['cekDefault' => $cekDefault]);
    }
}

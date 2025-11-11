<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Member; // Ganti dengan model Member Anda
use App\Models\Merchant;
use App\Models\PartnerUser;
use App\Models\Transaction; // Ganti dengan model Transaksi Anda
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class TransactionModal extends Component
{
    // ... (Properti dan method show, close, resetInput, findMember tetap sama) ...
    public $showModal = false;
    public $memberId;
    public $member;
    public $nominal;
    public $deskripsi;
    public $transactionType = '';
    public $currentBalance = 0; // TAMBAHAN: Untuk menyimpan saldo

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
        $this->currentBalance = 0; // TAMBAHAN: Reset saldo saat modal ditutup
    }

    public function findMember()
    {
        $this->member = Member::where('member_no', $this->memberId)->first();
        $this->currentBalance = 0; // TAMBAHAN: Reset saldo setiap pencarian baru

        if (!$this->member) {
            session()->flash('error', 'Member tidak ditemukan.');
            $this->member = null; // Pastikan member null jika tidak ada
        } else {
            // TAMBAHAN: Logika untuk menghitung saldo
            $wallet = Wallet::where('member_id', $this->member->id)->first();

            if ($wallet) {
                // 1. Hitung total topup
                $totalTopup = Transaction::where('wallet_id', $wallet->id)
                    ->where('type', 'topup')
                    ->sum('amount');

                // 2. Hitung total payment
                $totalPayment = Transaction::where('wallet_id', $wallet->id)
                    ->where('type', 'payment')
                    ->sum('amount');

                // 3. Set saldo saat ini
                $this->currentBalance = $totalTopup - $totalPayment;
            }
            // Jika tidak ada wallet, saldo tetap 0 (default)
        }
    }

    public function saveTransaction()
    {
        $user = Auth::user()->id;

        // Validasi harus dilakukan SETELAH member ditemukan
        // ... (Pengecekan $this->member, validasi, pengecekan wallet, partnerUser, merchant) ...
        if (!$this->member) {
            session()->flash('error', 'Silakan cari member terlebih dahulu.');
            return;
        }

        // Validasi input form
        $this->validate([
            'nominal' => 'required|numeric|min:1',
            'transactionType' => 'required|string',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        // Dapatkan data wallet & merchant
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


        // TAMBAHAN: Logika Pengecekan Saldo
        // ... (pengecekan saldo) ...
        if ($this->transactionType == 'payment') {
            // $this->currentBalance sudah dihitung saat findMember()
            if ($this->nominal > $this->currentBalance) {
                // Jika nominal pembayaran lebih besar dari saldo
                session()->flash('error', 'Transaksi Gagal! Saldo member tidak mencukupi (Saldo: Rp ' . number_format($this->currentBalance, 0, ',', '.') . ').');
                return; // Hentikan proses
            }
        }
        // AKHIR TAMBAHAN

        // Jika lolos validasi, buat transaksi
        try {

            // --- TAMBAHAN BARU: Generate TRX_ID ---
            // 1. Dapatkan format tanggal (misal: 11112025)
            $datePart = now()->format('dmY');

            // 2. Hitung jumlah transaksi hari ini untuk nomor urut
            $todayCount = Transaction::whereDate('created_at', today())->count();

            // 3. Buat nomor urut berikutnya, misal 0 + 1 = 1, lalu di-padding menjadi '001'
            //    (Kita set minimal 3 digit, misal '001'. Jika lebih dari 999, akan jadi '1000')
            $numberPart = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);

            // 4. Gabungkan semua bagian
            $generatedTrxId = 'TRX' . $datePart . $numberPart;
            // --- AKHIR TAMBAHAN BARU ---


            Transaction::create([
                'trx_id' => $generatedTrxId, // <-- FIELD BARU DITAMBAHKAN
                'wallet_id' => $wallet->id,
                'merchant_id' => $merchant->id,
                'type' => $this->transactionType,
                'amount' => $this->nominal,
                'description' => $this->deskripsi,
                'user_id' => $user,
            ]);
            $this->dispatch('success', message: 'Transaksi berhasil disimpan.');
            $this->dispatch('refreshDatatable');
            $this->close();
        } catch (\Exception $e) {
            $this->dispatch('error', message: 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaction-modal');
    }
}

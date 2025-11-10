<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Member; // Ganti dengan model Member Anda
use App\Models\Transaction; // Ganti dengan model Transaksi Anda
use Illuminate\Support\Facades\Auth;

class TransactionModal extends Component
{
    public $showModal = false;
    public $memberId;
    public $member;
    public $nominal;
    public $deskripsi;

    protected $listeners = ['openTransactionModal' => 'show'];

    public function show()
    {
        $this->resetInput(); // Bersihkan input setiap kali modal dibuka
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
    }

    /**
     * Cari member berdasarkan ID
     */
    public function findMember()
    {
        // Ganti 'kode_member' dengan nama kolom ID member Anda
        $this->member = Member::where('kode_member', $this->memberId)->first();

        if (!$this->member) {
            // Tampilkan pesan error jika member tidak ditemukan
            session()->flash('error', 'Member tidak ditemukan.');
        } else {
            // Hapus pesan error jika ada
            session()->forget('error');
        }
    }

    /**
     * Simpan transaksi
     */
    public function saveTransaction()
    {
        // Validasi
        $this->validate([
            'memberId' => 'required',
            'nominal' => 'required|numeric|min:1',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        // Pastikan member sudah ditemukan
        if (!$this->member) {
            session()->flash('error', 'Silakan cari member terlebih dahulu.');
            return;
        }

        // Logika penyimpanan transaksi
        try {
            Transaction::create([
                'member_id' => $this->member->id, // Ambil ID dari data member
                'amount' => $this->nominal,
                'description' => $this->deskripsi,
                'user_id' => Auth::user()->id, // Simpan ID kasir/admin
            ]);

            // Kirim notifikasi sukses
            session()->flash('success', 'Transaksi berhasil disimpan.');

            // Refresh tabel data (jika perlu)
            $this->emit('refreshTable'); // Asumsi tabel Anda mendengarkan event ini

            // Tutup modal
            $this->close();
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.transaction-modal');
    }
}

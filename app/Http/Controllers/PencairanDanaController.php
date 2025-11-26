<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Partner;
use App\Models\Transaction;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PencairanDanaController extends Controller
{

    public function index(Request $request)
    {
        $partners = Partner::with(['partnerWallet'])
            // Hanya Partner yang memiliki saldo lebih dari 0
            ->whereHas('partnerWallet', function ($q) {
                $q->where('balance', '>', 0);
            })
            ->get();
        $merchant = Merchant::where('partner_id', $partners->pluck('id'))->get();
        $pemasukan = Transaction::where('merchant_id', $merchant->pluck('id'))->where('type', 'payment')->whereDate('created_at', now()->today())->sum('amount_after_komisi');

        $data = [
            'page' => 'pencairanDana',
            'pageName' => 'Pencairan Dana Partner',
            'selected' => 'Pencairan Dana',
            'partners' => $partners,
            'pemasukan' => $pemasukan,
            'selectedPartner' => null,
            'balance' => 0,
            'withdrawals' => collect(),
        ];
        if ($request->has('partner_id')) {
            $partnerId = $request->partner_id;

            $selectedPartner = Partner::with(['partnerWallet', 'withdrawalRequest'])
                ->find($partnerId);

            if ($selectedPartner) {
                $data['selectedPartner'] = $selectedPartner;

                $data['balance'] = $selectedPartner->partnerWallet->balance ?? 0;
                $data['withdrawals'] = $selectedPartner->withdrawalRequest()
                    ->latest()
                    ->take(10)
                    ->get();
            } else {
                return redirect()->route('pencairanDana.index')->withErrors('Partner tidak ditemukan.');
            }
        }

        return view('v_page.pencairan_dana.index', $data);
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'amount' => 'required|numeric'
        ]);

        $partner = Partner::with('partnerWallet')->findOrFail($request->partner_id);
        $amount = (int) $request->amount;

        // 2. Pengecekan Saldo
        if (($partner->partnerWallet->balance ?? 0) < $amount) {
            return redirect()->back()
                ->withInput()
                ->withErrors('Saldo partner tidak mencukupi untuk jumlah penarikan (Rp ' . number_format($amount) . ').');
        }

        // 3. Eksekusi Transaksi Database
        DB::beginTransaction();
        try {
            // A. Catat Permintaan Pencairan
            WithdrawalRequest::create([
                'withdrawal_code' => 'WD-' . strtoupper(uniqid()),
                'user_id' => auth()->id(),
                'partner_id' => $partner->id,
                'amount' => $amount,
            ]);
            $partner->partnerWallet->decrement('balance', $amount);

            DB::commit();

            return redirect()->route('pencairanDana.index', ['partner_id' => $partner->id])
                ->with('success', 'Pencairan dana sebesar Rp ' . number_format($amount) . ' berhasil diproses untuk ' . $partner->name . '.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Catat error untuk debugging
            Log::error("Withdrawal processing failed for Partner ID: {$partner->id}. Error: " . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->withErrors('Terjadi kesalahan sistem saat memproses pencairan. Silakan cek log atau coba lagi.');
        }
    }
}

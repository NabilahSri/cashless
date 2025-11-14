<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Symfony\Component\Clock\now;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v_page.transaction.index', ['page' => 'transaksi', 'pageName' => 'Transaksi', 'selected' => 'Transaksi']);
    }

    /**
     * Show the form for creating a new resource.
     * Ini akan menangani tampilan form awal DAN tampilan setelah member dicari.
     */
    public function create(Request $request)
    {
        $data = [
            'page' => 'transaksi',
            'pageName' => 'Transaksi',
            'selected' => 'Transaksi',
            'member' => null,
            'currentBalance' => 0,
            'memberId' => $request->query('memberId', ''), // Ambil memberId dari query string
            'cekDefault' => ''
        ];

        // Cek $cekDefault (logika dari method render Livewire)
        if (auth()->user()->role == 'pengelola') {
            $cekPartner = PartnerUser::where('user_id', Auth::user()->id)->first();
            if ($cekPartner) {
                $data['cekDefault'] = Partner::where('id', $cekPartner->partner_id)->first();
            }
        }

        // Jika ada memberId di query string, coba cari member
        if ($data['memberId']) {
            $member = Member::where('member_no', $data['memberId'])->first();

            if (!$member) {
                // Jika member tidak ditemukan, kembali dengan error
                return redirect()->route('transaction.create')
                    ->with('error', 'Member tidak ditemukan.');
            }

            // Member ditemukan, dapatkan saldo
            $data['member'] = $member;
            $wallet = Wallet::where('member_id', $member->id)->first();
            if ($wallet) {
                $data['currentBalance'] = $wallet->balance ?? 0;
            }
        }

        return view('v_page.transaction.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * Ini akan menangani logika saveTransaction.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;

        // Validasi
        $validator = Validator::make($request->all(), [
            'memberId' => 'required|string|exists:members,member_no',
            'nominal' => 'required|numeric|min:1',
            'transactionType' => 'required|string',
            // 'deskripsi' => 'nullable|string|max:255',
            'pin' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data member berdasarkan memberId yang di-submit
        $member = Member::where('member_no', $request->input('memberId'))->first();
        if (!$member) {
            return redirect()->back()->withInput()->with('error', 'Member tidak valid.');
        }

        // Cek PIN
        if (!Hash::check($request->input('pin'), $member->pin)) {
            return redirect()->back()->withInput()->with('error', 'PIN transaksi salah. Transaksi gagal.');
        }

        // Ambil data lain (wallet, partner, merchant)
        $wallet = Wallet::where('member_id', $member->id)->first();
        if (!$wallet) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Wallet untuk member ini tidak ditemukan.');
        }

        $partnerUser = PartnerUser::where('user_id', $user)->first();
        if (!$partnerUser) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Akun Anda tidak terhubung dengan partner.');
        }

        $merchant = Merchant::where('partner_id', $partnerUser->partner_id)->first();
        if (!$merchant) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Merchant untuk partner Anda tidak ditemukan.');
        }

        // Cek saldo sebelum pembayaran
        if ($request->input('transactionType') === 'payment' && $request->input('nominal') > $wallet->balance) {
            return redirect()->back()->withInput()->with('error', 'Transaksi Gagal! Saldo member tidak mencukupi (Saldo: Rp ' . number_format($wallet->balance, 0, ',', '.') . ').');
        }

        try {
            // Generate ID Transaksi
            $datePart = now()->format('dmY');
            $todayCount = Transaction::whereDate('created_at', today())->count();
            $numberPart = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);
            $generatedTrxId = 'TRX' . $datePart . $numberPart;

            // Simpan transaksi
            Transaction::create([
                'trx_id' => $generatedTrxId,
                'wallet_id' => $wallet->id,
                'merchant_id' => $merchant->id,
                'type' => $request->input('transactionType'),
                'amount' => $request->input('nominal'),
                'description' => $request->input('deskripsi'),
                'user_id' => $user,
            ]);

            // Update saldo wallet
            if ($request->input('transactionType') === 'topup') {
                $wallet->balance += $request->input('nominal');
                $wallet->last_topup_at = now();
            } elseif ($request->input('transactionType') === 'payment') {
                $wallet->balance -= $request->input('nominal');
            }

            $wallet->save();

            // Redirect ke halaman create (form kosong) dengan pesan sukses
            return redirect()->route('transaction.create')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    // Metode lain (show, edit, update, destroy) tetap sama
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

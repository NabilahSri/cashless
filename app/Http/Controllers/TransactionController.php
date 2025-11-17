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
     */
    public function create(Request $request)
    {
        $data = [
            'page' => 'transaksi',
            'pageName' => 'Transaksi',
            'selected' => 'Transaksi',
            'member' => null,
            'currentBalance' => 0,
            'memberId' => null,
            'cardUid' => null,
            'qrCode' => null,
            'cekDefault' => ''
        ];

        if (auth()->user()->role == 'pengelola') {
            $cekPartner = PartnerUser::where('user_id', Auth::user()->id)->first();
            if ($cekPartner) {
                $data['cekDefault'] = Partner::where('id', $cekPartner->partner_id)->first();
            }
        }

        $member = null;
        $searchInput = null;
        $searchPerformed = false;
        $activeSearchTab = 'member';

        if ($request->has('memberId') && $request->filled('memberId')) {
            $searchInput = $request->memberId;
            $data['memberId'] = $searchInput;
            $member = Member::where('member_no', $searchInput)->first();
            $searchPerformed = true;
            $activeSearchTab = 'member';
        } elseif ($request->has('cardUid') && $request->filled('cardUid')) {
            $searchInput = $request->cardUid;
            $data['cardUid'] = $searchInput;
            $member = Member::where('card_uid', $searchInput)->first();
            $searchPerformed = true;
            $activeSearchTab = 'card';
        } elseif ($request->has('qrCode') && $request->filled('qrCode')) {
            $searchInput = $request->qrCode;
            $data['qrCode'] = $searchInput;
            $member = Member::where('member_no', $searchInput)->first();
            $searchPerformed = true;
            $activeSearchTab = 'qr';
        }

        if ($member) {
            $data['member'] = $member;
            $wallet = Wallet::where('member_id', $member->id)->first();
            if ($wallet) {
                $data['currentBalance'] = $wallet->balance ?? 0;
            }
        } elseif ($searchPerformed && !$member) {
            session()->flash('error', 'Member tidak ditemukan.');
        }

        $data['activeSearchTab'] = $activeSearchTab;

        return view('v_page.transaction.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'memberId' => 'required|string|exists:members,member_no',
            'nominal' => 'required|numeric|min:1',
            'transactionType' => 'required|string',
            'deskripsi' => 'nullable',
            'pin' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = Member::where('member_no', $request->input('memberId'))->first();
        if (!$member) {
            return redirect()->back()->withInput()->with('error', 'Member tidak valid.');
        }

        if (!Hash::check($request->input('pin'), $member->pin)) {
            return redirect()->back()->withInput()->with('error', 'PIN transaksi salah. Transaksi gagal.');
        }

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

        if ($request->input('transactionType') === 'payment' && $request->input('nominal') > $wallet->balance) {
            return redirect()->back()->withInput()->with('error', 'Transaksi Gagal! Saldo member tidak mencukupi (Saldo: Rp ' . number_format($wallet->balance, 0, ',', '.') . ').');
        }

        try {
            $datePart = now()->format('dmY');
            $todayCount = Transaction::whereDate('created_at', today())->count();
            $numberPart = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);
            $generatedTrxId = 'TRX' . $datePart . $numberPart;

            Transaction::create([
                'trx_id' => $generatedTrxId,
                'wallet_id' => $wallet->id,
                'merchant_id' => $merchant->id,
                'type' => $request->input('transactionType'),
                'amount' => $request->input('nominal'),
                'description' => $request->input('deskripsi'),
                'user_id' => $user,
            ]);

            if ($request->input('transactionType') === 'topup') {
                $wallet->balance += $request->input('nominal');
                $wallet->last_topup_at = now();
            } elseif ($request->input('transactionType') === 'payment') {
                $wallet->balance -= $request->input('nominal');
            }

            $wallet->save();

            return redirect()->route('transaction.create')->with('success', 'Transaksi berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

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

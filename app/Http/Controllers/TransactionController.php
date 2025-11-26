<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Merchant;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\PartnerWallet;
use App\Models\QRToken;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
            'limitInfo' => null,
            'usedAmount' => 0,
            'remainingLimit' => 0,
            'memberId' => null,
            'cardUid' => null,
            'qrCode' => null,
            'cekDefault' => '',
            'qrCodeToken' => null,
            'recommendations' => [],
            'walletBalance' => 0,
            'mode' => $request->get('mode'),
            'pinValid' => false,
        ];

        if ($data['mode'] === 'cek_saldo') {
            $data['page'] = 'cek_saldo';
            $data['pageName'] = 'Cek Saldo';
            $data['selected'] = 'Cek Saldo';
        }

        if (auth()->user()->role == 'pengelola') {
            $cekPartner = PartnerUser::where('user_id', Auth::user()->id)->first();
            if ($cekPartner) {
                $data['cekDefault'] = Partner::where('id', $cekPartner->partner_id)->first();
            }
        }

        $member = null;
        $searchInput = null;
        $searchPerformed = false;
        $activeSearchTab = 'card';

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
        } elseif ($request->has('qrCode') && $request->filled('qrCode') && $request->get('mode') !== 'cek_saldo') {
            $searchInput = $request->qrCode;
            $data['qrCode'] = $searchInput;
            $searchPerformed = true;
            $activeSearchTab = 'qr';
            $token = QRToken::where('token', $searchInput)->first();
            if (!$token) {
                session()->flash('error', 'QR Code tidak valid atau tidak ditemukan.');
                $member = null;
            } elseif ($token->used_at) {
                session()->flash('error', 'QR Code ini sudah pernah digunakan.');
                $member = null;
            } else {
                $member = Member::where('id', $token->member_id)->first();
                if (!$member) {
                    session()->flash('error', 'Token valid, tapi data member terkait tidak ditemukan.');
                } else {
                    $data['qrCodeToken'] = $token->token;
                    $req = Cache::get('qr_request_' . $token->token);
                    if ($req && isset($req['amount'])) {
                        $data['prefilledNominal'] = (int)$req['amount'];
                    }
                }
            }
        }

        if ($member) {
            $data['member'] = $member;
            $limitInfo = $this->calculateTransactionLimit($member);
            $data['limitInfo'] = $limitInfo;
            $data['usedAmount'] = $limitInfo['used_amount'];
            $data['remainingLimit'] = $limitInfo['remaining_limit'];

            $wallet = Wallet::where('member_id', $member->id)->first();
            if ($wallet) {
                // Untuk mode transaksi biasa, ambil rekomendasi nominal
                $recommendations = Transaction::selectRaw('amount, COUNT(*) as cnt, MAX(created_at) as last_used')
                    ->where('wallet_id', $wallet->id)
                    ->groupBy('amount')
                    ->orderByDesc('cnt')
                    ->orderByDesc('last_used')
                    ->limit(5)
                    ->get()
                    ->pluck('amount')
                    ->toArray();
                $data['recommendations'] = $recommendations;

                // Mode cek saldo: wajib PIN meskipun status_pin inactive
                if ($data['mode'] === 'cek_saldo') {
                    $pin = $request->input('pin');
                    if ($pin === null) {
                        // Tidak ada PIN, tidak tampilkan saldo
                        $data['pinValid'] = false;
                    } else {
                        if (empty($member->pin)) {
                            session()->flash('error', 'PIN belum diatur untuk member ini.');
                            $data['pinValid'] = false;
                        } elseif (!\Illuminate\Support\Facades\Hash::check($pin, $member->pin)) {
                            session()->flash('error', 'PIN salah.');
                            $data['pinValid'] = false;
                        } else {
                            $data['pinValid'] = true;
                            $data['walletBalance'] = (int) $wallet->balance;
                        }
                    }
                } else {
                    // Mode normal: saldo tidak ditampilkan di halaman ini
                }
            }
        } elseif ($searchPerformed && !$member) {
            session()->flash('error', 'Member tidak ditemukan.');
        }

        $data['activeSearchTab'] = $activeSearchTab;

        return view('v_page.transaction.create', $data);
    }

    public function checkBalance(Request $request)
    {
        $member = null;
        if ($request->filled('memberId')) {
            $member = Member::where('member_no', $request->memberId)->first();
        } elseif ($request->filled('cardUid')) {
            $member = Member::where('card_uid', $request->cardUid)->first();
        }
        if (!$member) {
            return response()->json(['success' => false, 'error' => 'Member tidak ditemukan'], 404);
        }
        $pin = $request->input('pin');
        if ($pin === null || $pin === '') {
            return response()->json(['success' => false, 'error' => 'PIN wajib diisi'], 400);
        }
        if (empty($member->pin)) {
            return response()->json(['success' => false, 'error' => 'PIN belum diatur untuk member ini'], 400);
        }
        if (!Hash::check($pin, $member->pin)) {
            return response()->json(['success' => false, 'error' => 'PIN salah'], 401);
        }
        $wallet = Wallet::where('member_id', $member->id)->first();
        $balance = $wallet ? (int) $wallet->balance : 0;
        return response()->json(['success' => true, 'balance' => $balance]);
    }

    private function calculateTransactionLimit($member)
    {
        $limitType = $member->status_limit; // 'daily', 'weekly', 'monthly'
        $limitAmount = $member->limit_transaction;

        // Jika tidak ada limit, return unlimited
        if ($limitType === 'no_limit') {
            return [
                'limit_type' => 'no_limit',
                'limit_amount' => 0,
                'used_amount' => 0,
                'remaining_limit' => 0,
                'period' => 'Tidak ada limit',
                'is_exceeded' => false
            ];
        }

        $now = Carbon::now();
        $startDate = null;
        $endDate = null;
        $periodText = '';

        // Tentukan rentang waktu berdasarkan jenis limit
        switch ($limitType) {
            case 'daily':
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $periodText = 'Hari Ini';
                break;

            case 'weekly':
                $startDate = $now->copy()->startOfWeek();
                $endDate = $now->copy()->endOfWeek();
                $periodText = 'Minggu Ini';
                break;

            case 'monthly':
                $startDate = $now->copy()->startOfMonth();
                $endDate = $now->copy()->endOfMonth();
                $periodText = 'Bulan Ini';
                break;

            default:
                $startDate = $now->copy()->startOfDay();
                $endDate = $now->copy()->endOfDay();
                $periodText = 'Hari Ini';
                break;
        }

        $wallet = Wallet::where('member_id', $member->id)->first();

        // Hitung total transaksi dalam periode tersebut
        $usedAmount = Transaction::where('wallet_id', $wallet->id)
            ->where('type', 'payment')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('amount');

        $remainingLimit = max(0, $limitAmount - $usedAmount);
        $isExceeded = $usedAmount >= $limitAmount;

        return [
            'limit_type' => $limitType,
            'limit_amount' => $limitAmount,
            'used_amount' => $usedAmount,
            'remaining_limit' => $remainingLimit,
            'period' => $periodText,
            'is_exceeded' => $isExceeded,
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
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
            'deskripsi' => 'nullable',
            'pin' => 'string|' . (Member::where('member_no', $request->input('memberId'))->first() && Member::where('member_no', $request->input('memberId'))->first()->status_pin == 'active' ? 'required' : 'nullable'),
            'qrToken' => 'nullable|string|exists:qr_tokens,token',
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

        if ($member->pin == 'active') {
            if (!Hash::check($request->input('pin'), $member->pin)) {
                return redirect()->back()->withInput()->with('error', 'PIN transaksi salah. Transaksi gagal.');
            }
        }

        $wallet = Wallet::where('member_id', $member->id)->first();
        if (!$wallet) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Wallet untuk member ini tidak ditemukan.');
        }

        $partnerUser = PartnerUser::where('user_id', $user)->first();
        $PartberName = Partner::where('id', $partnerUser->partner_id)->first();
        if (!$partnerUser) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Akun Anda tidak terhubung dengan partner.');
        }

        $merchant = Merchant::where('partner_id', $partnerUser->partner_id)->first();
        if (!$merchant) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Merchant untuk partner Anda tidak ditemukan.');
        }

        $nominal = (int)$request->input('nominal');
        $transactionType = $PartberName->status == true ? 'topup' : 'payment';
        // 1. Pengecekan Saldo (Hanya untuk Payment)
        if ($transactionType === 'payment' && $nominal > $wallet->balance) {
            return redirect()->back()->withInput()->with('error', 'Transaksi Gagal! Saldo member tidak mencukupi (Saldo: Rp ' . number_format($wallet->balance, 0, ',', '.') . ').');
        }

        // 2. Pengecekan Limit Transaksi (Hanya untuk Payment)
        if ($transactionType === 'payment') {
            $limitInfo = $this->calculateTransactionLimit($member);
            $remainingLimit = $limitInfo['remaining_limit'];

            if ($nominal > $remainingLimit) {
                return redirect()->back()->withInput()->with('error', 'Transaksi Gagal! Jumlah nominal melebihi sisa limit transaksi (Sisa Limit: Rp ' . number_format($remainingLimit, 0, ',', '.') . ').');
            }
        }

        $qrToken = null;
        if ($request->filled('qrToken')) {
            $qrToken = QrToken::where('token', $request->input('qrToken'))->first();

            if ($qrToken->member_id != $member->id) {
                return redirect()->back()->withInput()->with('error', 'Token QR tidak sesuai dengan member.');
            }
            if ($qrToken->used_at) {
                return redirect()->back()->withInput()->with('error', 'QR Code ini sudah terpakai di transaksi lain.');
            }
        }

        try {
            $datePart = now()->format('dmY');
            $todayCount = Transaction::whereDate('created_at', today())->count();
            $numberPart = str_pad($todayCount + 1, 3, '0', STR_PAD_LEFT);
            $generatedTrxId = 'TRX' . $datePart . $numberPart;

            $wallet_partner = PartnerWallet::where('partner_id', $partnerUser->partner_id)->first();
            $komisi = 0;
            $komisi_amount = 0;
            $amount_after_komisi = $request->input('nominal');
            if ($transactionType === 'payment') {
                $komisi = Partner::where('id', $partnerUser->partner_id)->first()->komisi;
                $komisi_amount = ($request->input('nominal') * $komisi) / 100;
                $amount_after_komisi = $request->input('nominal') - $komisi_amount;
            }

            Transaction::create([
                'trx_id' => $generatedTrxId,
                'wallet_id' => $wallet->id,
                'merchant_id' => $merchant->id,
                'type' => $transactionType,
                'amount' => $request->input('nominal'),
                'komisi' => $komisi,
                'komisi_amount' => $komisi_amount,
                'amount_after_komisi' => $amount_after_komisi,
                'description' => $request->input('deskripsi'),
                'user_id' => $user,
            ]);

            if ($transactionType === 'topup') {
                $wallet->balance += $request->input('nominal');
                $wallet->last_topup_at = now();
            } elseif ($transactionType === 'payment') {
                $wallet->balance -= $request->input('nominal');
                $wallet_partner->balance += $amount_after_komisi;
                $wallet_partner->save();
            }

            $wallet->save();

            if ($qrToken) {
                $qrToken->update(['used_at' => now()]);
                $cacheKey = 'qr_data_' . $qrToken->token;
                $cacheData = [
                    'amount' => $request->input('nominal'),
                    'type' => $transactionType
                ];
                Cache::put($cacheKey, $cacheData, \Carbon\Carbon::now()->addMinutes(2));
            }

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

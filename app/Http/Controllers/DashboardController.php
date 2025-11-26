<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Merchant;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\PartnerWallet;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'member') {
            $member = Member::where('user_id', auth()->user()->id)->first();
            $wallet = Wallet::where('member_id', $member->id)->first();
            $pemasukan = Transaction::where('wallet_id', $wallet->id)->where('type', 'topup')->sum('amount');
            $pengeluaran = Transaction::where('wallet_id', $wallet->id)->where('type', 'payment')->sum('amount');
            $transaksi = Transaction::where('wallet_id', $wallet->id)->get();
            return view('v_page.dahsboard.dashboard-member', ['page' => 'dashboard', 'pageName' => 'Dashboard', 'member' => $member, 'wallet' => $wallet, 'pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran, 'transaksi' => $transaksi]);
        } else if (auth()->user()->role == 'pengelola') {
            $partner = PartnerUser::where('user_id', auth()->user()->id)->first();
            $status_partner = Partner::where('id', $partner->partner_id)->first()->status;
            $merchant = Merchant::where('partner_id', $partner->partner_id)->first();
            $pemasukan = Transaction::where('merchant_id', $merchant->id)->where('type', 'payment')->sum('amount_after_komisi');
            $total_pengelola = PartnerUser::where('partner_id', $partner->partner_id)->count();
            $pemasukan_hari_ini = Transaction::where('merchant_id', $merchant->id)->where('type', 'payment')->whereDate('created_at', now()->today())->sum('amount_after_komisi');
            $saldo = PartnerWallet::where('partner_id', $partner->partner_id)->first();
            $penarikan = WithdrawalRequest::where('partner_id', $partner->partner_id)->sum('amount');
            $total_topup = Transaction::where('user_id', auth()->user()->id)->where('type', 'topup')->sum('amount');
            $total_pencairan = WithdrawalRequest::where('user_id', auth()->user()->id)->sum('amount');
            return view('v_page.dahsboard.dashboard-pengelola', ['total_pencairan' => $total_pencairan, 'total_topup' => $total_topup, 'page' => 'dashboard', 'pageName' => 'Dashboard', 'pemasukan' => $pemasukan, 'total_pengelola' => $total_pengelola, 'pemasukan_hari_ini' => $pemasukan_hari_ini, 'status_partner' => $status_partner, 'saldo' => $saldo, 'penarikan' => $penarikan, 'partner' => $partner]);
        } else {
            $data['admin'] = User::where('role', 'admin')->count();
            $data['pengelola'] = User::where('role', 'Pengelola')->count();
            $member = User::where('role', 'member')->get();
            $data['member_aktif'] = Member::whereIn('user_id', $member->pluck('id'))->where('status_member', 'active')->count();
            $data['partner'] = Partner::count();
            $data['pemasukan_hari_ini'] = Transaction::where('type', 'payment')->whereDate('created_at', now()->today())->sum('amount');
            $data['pemasukan'] = Transaction::where('type', 'payment')->sum('amount');
            return view('v_page.dahsboard.index', ['page' => 'dashboard', 'pageName' => 'Dashboard', 'data' => $data]);
        }
    }
}

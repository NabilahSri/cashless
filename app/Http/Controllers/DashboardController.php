<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Transaction;
use App\Models\Wallet;
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
        }
        return view('v_page.dahsboard.index', ['page' => 'dashboard', 'pageName' => 'Dashboard']);
    }
}

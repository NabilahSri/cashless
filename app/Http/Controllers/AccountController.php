<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $member = Member::where('user_id', auth()->user()->id)->first();
        $walletBalance = 0;
        if ($member) {
            $wallet = Wallet::where('member_id', $member->id)->first();
            $walletBalance = $wallet ? (int)$wallet->balance : 0;
        }
        return view('v_page.account.index', [
            'page' => 'pengaturan profil',
            'pageName' => 'Pengaturan Profil',
            'selected' => 'Pengaturan Profil',
            'member' => $member,
            'walletBalance' => $walletBalance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $validatedData = $request->validate([
            'username' => 'required',
            'password'  => 'nullable|string',
        ]);
        $userData = [
            'username' => $validatedData['username'],
        ];
        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->input('password'));
        }
        $user = User::findOrFail($id);
        $user->update($userData);
        return redirect()->back()->with('success', 'Informasi akun berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function personalInformation($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->update(['name' => $request->name]);
        $member = Member::where('user_id', $user->id)->first();
        $memberData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'limit_transaction' => str_replace('.', '', $request->limit_transaction),
            'status_limit' => $request->status_limit,
            'status_pin' => $request->status_pin
        ];

        if (!empty($request->input('pin'))) {
            $memberData['pin'] = bcrypt($request->input('pin'));
        }

        $member->update($memberData);
        return redirect()->back()->with('success', 'Informasi pribadi berhasil diperbarui.');
    }
}

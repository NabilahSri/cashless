<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v_page.pengguna.member.index', ['page' => 'member', 'pageName' => 'Member', 'selected' => 'Pengguna']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prefix = 'MB';
        $now = Carbon::now();
        $month = $now->format('m');
        $year = $now->format('y');
        $currentPrefix = $prefix . $month . $year;
        $lastMember = Member::where('member_no', 'LIKE', $currentPrefix . '%')
            ->orderBy('member_no', 'desc')
            ->first();
        $newNumber = 1;
        if ($lastMember) {
            $prefixLength = strlen($currentPrefix);
            $lastNumberStr = substr($lastMember->member_no, $prefixLength);
            $newNumber = (int)$lastNumberStr + 1;
        }
        $newMemberNo = $currentPrefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        return view('v_page.pengguna.member.create', [
            'page' => 'member',
            'pageName' => 'Member',
            'selected' => "Pengguna",
            'newMemberNo' => $newMemberNo
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'member_no' => 'required|string|unique:members,member_no',
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:100|unique:users,username',
            'email'     => 'required|email|max:255|unique:members,email',
            'phone'     => 'required|string|max:20',
            'card_uid'  => 'required|string|max:100|unique:members,card_uid',
            'address'   => 'nullable|string',
            'password'  => 'required|string',
        ]);
        try {
            DB::transaction(function () use ($validatedData) {
                $userData = [
                    'name' => $validatedData['name'],
                    'username' => $validatedData['username'],
                    'password' => $validatedData['password'],
                    'role' => 'member',
                ];
                $newUser = User::create($userData);
                $memberData = [
                    'user_id' => $newUser->id,
                    'member_no' => $validatedData['member_no'],
                    'name' => $newUser->name,
                    'email' => $validatedData['email'],
                    'phone' => $validatedData['phone'],
                    'card_uid' => $validatedData['card_uid'],
                    'address' => $validatedData['address'],
                ];
                $newMember = Member::create($memberData);
                Wallet::create([
                    'member_id' => $newMember->id,
                    'balance' => 0,
                    'last_topup_at' => null,
                ]);
            });
            DB::commit();
            return redirect()->route('member.index')->with('success', 'Data member baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
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
        $member = Member::with('user')->findOrFail($id);
        return view('v_page.pengguna.member.edit', ['page' => 'member', 'pageName' => 'Member', 'member' => $member]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);
        $validatedData = $request->validate([
            'member_no' => 'required|string|' . Rule::unique('members')->ignore($member->id),
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255|' . Rule::unique('members')->ignore($member->id),
            'phone'     => 'required|string|max:20|' . Rule::unique('members')->ignore($member->id),
            'card_uid'  => 'required|string|max:100|' . Rule::unique('members')->ignore($member->id),
            'address'   => 'required|string',
            'username'  => 'required|string|max:100|' . Rule::unique('users')->ignore($member->user_id),
            'password'  => 'nullable|string',
        ]);
        try {
            DB::transaction(function () use ($validatedData, $member, $request) {
                $userData = [
                    'name' => $validatedData['name'],
                    'username' => $validatedData['username'],
                ];
                if ($request->filled('password')) {
                    $userData['password'] = bcrypt($request->input('password'));
                }
                $member->user->update($userData);
                $member->update([
                    'member_no' => $validatedData['member_no'],
                    'name'      => $userData['name'],
                    'email'    => $validatedData['email'],
                    'phone'     => $validatedData['phone'],
                    'card_uid'  => $validatedData['card_uid'],
                    'address'   => $validatedData['address'],
                ]);
            });
            return redirect()->route('member.index')->with('success', 'Data member berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

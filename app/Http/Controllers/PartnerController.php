<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\User;
use Egulias\EmailValidator\Parser\PartParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('v_page.partner.index', ['page' => 'partner', 'pageName' => 'Partner', 'selected' => 'Partner']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengelola = User::where('role', 'pengelola')->get();
        return view('v_page.partner.create', [
            'page' => 'partner',
            'pageName' => 'Partner',
            'selected' => 'Partner',
            'pengelola' => $pengelola
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|unique:partners,name',
            'email' => 'required|email|unique:partners,email',
            'phone' => 'required',
            'address' => 'required',
            'status' => 'nullable',
            'user_id' => 'nullable|array',
            'user_id.*' => 'exists:users,id'
        ]);
        DB::beginTransaction();
        if ($validateData['status'] == 1) {
            $cekDefault = Partner::where('status', true)->first();
            if ($cekDefault) {
                return redirect()->back()->with('error', 'Data partner default sudah ada.');
            }
        }
        try {
            $partner = Partner::create($request->except('user_id'));
            $userIds = $request->input('user_id', [null]);
            $newPartnerId = $partner->id;
            foreach ($userIds as $userId) {
                PartnerUser::create([
                    'partner_id' => $newPartnerId,
                    'user_id' => $userId,
                ]);
            }
            DB::commit();
            return redirect()->route('partner.index')->with('success', 'Data partner baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
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
        $pengelola = User::where('role', 'pengelola')->get();
        $partner = Partner::find($id);
        $user_id = PartnerUser::where('partner_id', $id)->pluck('user_id');
        return view('v_page.partner.edit', ['page' => 'partner', 'pageName' => 'Partner', 'selected' => 'Partner', 'pengelola' => $pengelola, 'partner' => $partner, 'user_id' => $user_id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $partner = Partner::find($id);
        $validateData = $request->validate([
            'name' => 'required|' . Rule::unique('partners')->ignore($partner->id),
            'email' => 'required|email|' . Rule::unique('partners')->ignore($partner->id),
            'phone' => 'required',
            'address' => 'required',
            'status' => 'nullable',
            'user_id' => 'nullable|array',
            'user_id.*' => 'exists:users,id'
        ]);
        DB::beginTransaction();
        $cekDefault = Partner::where('status', true)->first();
        if ($cekDefault) {
            return redirect()->back()->with('error', 'Data partner default sudah ada.');
        }
        try {
            $partner->update($request->except('user_id'));
            $userIds = $request->input('user_id', [null]);
            PartnerUser::where('partner_id', $id)->delete();
            foreach ($userIds as $userId) {
                PartnerUser::create([
                    'partner_id' => $id,
                    'user_id' => $userId,
                ]);
            }
            DB::commit();
            return redirect()->route('partner.index')->with('success', 'Data partner berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
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

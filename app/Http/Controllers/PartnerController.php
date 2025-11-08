<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

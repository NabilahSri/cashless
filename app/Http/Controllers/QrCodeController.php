<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function show()
    {
        if (auth()->user()->role != 'member') {
            abort(403);
        }
        return view('v_page.qr_code.show', ['page' => 'qr_code', 'pageName' => 'Qr Code', 'selected' => 'Qr Code']);
    }
}

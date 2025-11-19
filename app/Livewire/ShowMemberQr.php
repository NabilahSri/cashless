<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\QrToken;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Livewire\Component;

class ShowMemberQr extends Component
{
    public $token;
    public $qrString;
    public $expiresAt;
    public $transactionSuccessful = false;
    public $successAmount = 0;
    public $successType = '';

    public function mount()
    {
        $this->generate();
    }

    public function generate()
    {
        $this->transactionSuccessful = false;
        $this->successAmount = 0;
        $this->successType = '';

        $user = auth()->user();
        $memberId = Member::where('user_id', $user->id)->first()->id;


        QrToken::where('member_id', $memberId)
            ->whereNull('used_at')
            ->update(['expires_at' => now()]);

        $newToken = Str::random(60);
        $expiryTime = now()->addMinutes(5);

        $tokenModel = QrToken::create([
            'member_id' => $memberId,
            'token' => $newToken,
            'expires_at' => $expiryTime,
        ]);

        $this->token = $tokenModel->token;
        $this->qrString = $tokenModel->token;
        $this->expiresAt = $expiryTime->toIso8601String();
        $this->dispatch('qrGenerated', expiresAt: $this->expiresAt);
    }

    public function checkStatus()
    {
        if ($this->transactionSuccessful) {
            return;
        }

        $currentToken = QrToken::where('token', $this->token)->first();

        if (!$currentToken) {
            $this->generate();
            return;
        }

        if ($currentToken->used_at) {
            $this->transactionSuccessful = true;
            $cacheKey = 'qr_data_' . $this->token;
            $cachedData = Cache::get($cacheKey);

            if ($cachedData) {
                $this->successAmount = $cachedData['amount'];
                $this->successType = $cachedData['type'];
                Cache::forget($cacheKey);
            }
            $this->dispatch('transactionSuccess');
        } elseif ($currentToken->expires_at < now()) {
            $this->generate();
        }
    }

    public function render()
    {
        return view('livewire.show-member-qr');
    }
}

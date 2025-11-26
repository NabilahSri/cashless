<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Merchant;
use App\Models\Partner;
use App\Models\PartnerUser;
use App\Models\PartnerWallet;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $user = User::create([
            'name' => "Pengelola Admin",
            'username' => 'adminpengelola',
            'password' => bcrypt('12341234'),
            'role' => 'pengelola',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user2 = User::create([
            'name' => "SMK YPC",
            'username' => 'smkypc',
            'password' => bcrypt('12341234'),
            'role' => 'pengelola',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $partner = Partner::create([
            'name' => 'YAYASAN',
            'address' => 'Jl. Partner No.1, Kota Contoh',
            'phone' => '081234567890',
            'email' => 'bVd7o@example.com',
            'komisi' => 5,
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerUser::create([
            'partner_id' => $partner->id,
            'user_id' => $user->id,
            'is_admin' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerUser::create([
            'partner_id' => $partner->id,
            'user_id' => $user2->id,
            'is_admin' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        PartnerWallet::create([
            'partner_id' => $partner->id,
            'balance' => 0
        ]);

        Merchant::create([
            'name' => 'SMK YPC',
            'partner_id' => $partner->id,
            'device_id' => '122-222',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

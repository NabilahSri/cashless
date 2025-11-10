<?php

namespace Database\Seeders;

use App\Models\Member;
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
        $faker = Faker::create('id_ID'); // Menggunakan data Indonesia

        for ($i = 1; $i <= 11; $i++) {
            // Buat User-nya dulu
            $userMember = User::create([
                'name' => $faker->name,
                'username' => $faker->unique()->userName,
                'password' => bcrypt('password'), // password default
                'role' => 'member',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Buat data Member-nya, terhubung dengan user_id di atas
            $member = Member::create([
                'user_id' => $userMember->id,
                'member_no' => 'M' . str_pad($i + 1, 4, '0', STR_PAD_LEFT), // M0002, M0003, dst.
                'name' => $userMember->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'card_uid' => $faker->uuid,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Wallet::create([
                'member_id' => $member->id,
                'balance' => 0,
                'last_topup_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

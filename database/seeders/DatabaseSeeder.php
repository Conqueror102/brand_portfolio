<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Creates the first owner account from ADMIN_EMAIL / ADMIN_PASSWORD, then the sample content.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@modupe.test')],
            ['name' => env('ADMIN_NAME', 'Site Owner'), 'role' => 'owner', 'password' => env('ADMIN_PASSWORD', 'ChangeMe-2026!')],
        );

        $this->call([SiteContentSeeder::class, SampleContentSeeder::class, AuthorityContentSeeder::class]);
    }
}

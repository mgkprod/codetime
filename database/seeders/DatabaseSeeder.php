<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if (config('app.env') === 'local') {
            User::firstOrCreate([
                'email' => 'sr@mgk.dev',
            ], [
                'name' => 'Simon Rubuano',
                'password' => Hash::make('1234'),
                'email_verified_at' => now(),
            ]);
        }
    }
}

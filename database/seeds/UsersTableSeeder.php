<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                'name' => 'Simon',
                'password' => \Hash::make('1234'),
                'email_verified_at' => now(),
            ]);
        }
    }
}

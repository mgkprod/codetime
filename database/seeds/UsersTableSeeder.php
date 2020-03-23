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
                'name' => 'MGK',
                'password' => \Hash::make('1234'),
                'api_key' => '626664d5-5639-4a80-a40c-785a02eeee0e',
                'email_verified_at' => now(),
            ]);
        }
    }
}

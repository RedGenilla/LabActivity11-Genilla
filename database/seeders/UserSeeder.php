<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create the Kagawad login account.
        $kagawad = User::updateOrCreate(
            ['email' => 'kagawad.genilla@bulletin.test'],
            [
                'name' => 'Red Genilla',
                'password' => Hash::make('bulletin2026'),
            ]
        );

        // Create Lola Genilla's resident account.
        User::updateOrCreate(
            ['email' => 'lola.genilla@bulletin.test'],
            [
                'name' => 'Lola Genilla',
                'password' => Hash::make('bulletin2026'),
            ]
        );

        // Link the existing Kagawad author to the account.
        $author = Author::where(
            'email',
            'kagawad.genilla@bulletin.test'
        )->firstOrFail();

        $author->update([
            'user_id' => $kagawad->id,
        ]);

        // Add eight more resident accounts.
        User::factory()->count(8)->create();
    }
}


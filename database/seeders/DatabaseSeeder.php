<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Contact::factory(5)->create();

        Transaction::factory()->count(1000)->create();
    }
}

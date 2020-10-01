<?php

use App\Models\SharedNote;
use Illuminate\Database\Seeder;

class SharedNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SharedNote::class, 20)->create();
    }
}

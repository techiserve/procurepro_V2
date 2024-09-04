<?php

namespace Database\Seeders;
use App\Models\userrole;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserroleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        userrole::create([

            'name' => 'Super Admin',
            'description' => 'handles all functionality of the system',
    
        ]);
    }
}

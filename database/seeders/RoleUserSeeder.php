<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $user = User::where('email', 'test@example.com')->first();
        $user->assignRole('contador');
       /* $user = User::where('email', 'test@example.com')->first();
        $user->assignRole('admin');*/



    }
}

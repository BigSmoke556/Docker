<?php
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Teste User',
            'email' => 'user@empresa.com',
            'password' => Hash::make('123456'),
            'company_id' => 1
        ]);
    }
}
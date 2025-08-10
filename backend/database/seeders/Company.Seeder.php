<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        Company::create(['name' => 'Empresa A']);
        Company::create(['name' => 'Empresa B']);
    }
}
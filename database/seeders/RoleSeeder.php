<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['Role_name'=>'The Ceo','email'=>'super@admin.com']);
        Role::create(['Role_name'=>'General Manager','email'=>'manager@admin.com']);
        Role::create(['Role_name'=>'The Accountant','email'=>'accountant@admin.com']);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadminrole=Role::where(['Role_name'=>'The Ceo','email'=>'super@admin.com'])->first();
        $normaladminrole=Role::where(['Role_name'=>'General Manager','email'=>'manager@admin.com'])->first();
        $normaladminrole2=Role::where(['Role_name'=>'The Accountant','email'=>'accountant@admin.com'])->first();

        $superAdmin=User::create([
            // 'username'=>'Super-Admin 1',
            'first_name'=>'The Ceo',
            'last_name'=>'Super Admin',
            'is_admin'=>1,
            'email'=>'super@admin.com',
            'role_id'=>'1',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $normalAdmin=User::create([
            // 'username'=>'Normal-Admin 1',
            'first_name'=>'The General Manager',
            'last_name'=>'Manager',
            'is_admin'=>1,
            'role_id'=>'2',
            'email'=>'manager@admin.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);
        $normalAdmin2=User::create([
            // 'username'=>'Normal-Admin 1',
            'first_name'=>'The Accountant',
            'last_name'=>'Accountant',
            'is_admin'=>1,
            'role_id'=>'3',
            'email'=>'accountant@admin.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password'),
            'remember_token'=>Str::random(10)
        ]);

        $superAdmin->roles()->attach($superadminrole);
        $normalAdmin->roles()->attach($normaladminrole);
        $normalAdmin2->roles()->attach($normaladminrole2);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin','seller','customer'];

        foreach($roles as $role){
            $exist = Role::where('name',$role)->first();
            if(empty($exist)){
                Role::create(['name'=>$role]);
            }
        }
    }
}

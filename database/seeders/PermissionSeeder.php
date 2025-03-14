<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create dishes']);
        Permission::create(['name' => 'delete dishes']);
        $admin= Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo('create dishes');
        $admin->givePermissionTo('delete dishes');
    }
}

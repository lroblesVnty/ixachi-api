<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $adminRole = Role::create(['name' => 'admin']);
        $gestorRole = Role::create(['name' => 'gestor']);
        $levantadorRole = Role::create(['name' => 'levantador de afectaciones']);
        $contaRole = Role::create(['name' => 'contador']);

        $addLevsPermission = Permission::create(['name' => 'add levs']);
        $deleteLevsPermission = Permission::create(['name' => 'delete levs']);
        $addPermission = Permission::create(['name' => 'add permisos']);
        $validSatPermission = Permission::create(['name' => 'valid SAT']);

        $adminRole->givePermissionTo([$addLevsPermission, $deleteLevsPermission,$validSatPermission]);
        $levantadorRole->givePermissionTo($addLevsPermission);
        $gestorRole->givePermissionTo($addPermission);
        $contaRole->givePermissionTo($validSatPermission);

    }
}

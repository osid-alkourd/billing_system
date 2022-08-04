<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'invoices',
            'invoicing list',
            'paid invoices',
            'partially paid invoices',
            'unpaid invoices',
            'Invoices Archive',
            'reports',
            'invoicing report',
            'customer Report',
            'users',
            'users list',
            'users permissions',
            'setting',
            'products',
            'sections',

            'add invoice',
            'delete invoice',
            'excel export',
            'change status payment',
            'update invoice',
            'Archive invoice',
            'print invoice',
            'add attachment',
            'delete attachment',

            'add user',
            'update user',
            'delete user',

            'show permissions',
            'add permission',
            'update permission',
            'delete permission',

            'add product',
            'update product',
            'delete product',

            'add section',
            'update section',
            'delete section',
            'notifications',
            ];

        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }




    }
}
